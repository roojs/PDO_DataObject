<?php
/**
 * Generate package2.xml and composer.json from CHANGELOG.md (source of truth
 * for version, date, and notes) plus the PDO/ tree (file list).
 *
 * Usage:
 *   php scripts/release/package.php           write both files
 *   php scripts/release/package.php --check   exit 1 if they are stale
 */
declare(strict_types=1);

const PHP_MIN = '8.4';
const PHP_MIN_PEAR = '8.4.0';
const API_VERSION = '2.0.0';
const STABILITY = 'beta';
const COMPOSER_NAME = 'roojs/pdo_dataobject';
const PACKAGE_NAME = 'PDO_DataObject';
const CHANNEL = 'roojs.github.com/pear-channel';
const HOMEPAGE = 'https://github.com/roojs/PDO_DataObject';
const LICENSE_URI = 'https://www.gnu.org/licenses/lgpl-3.0.en.html';
const SUMMARY = 'An SQL Builder, Object Interface to Database Tables';
const DESCRIPTION = <<<'TXT'
DataObject performs 2 tasks:
  1. Builds SQL statements based on the objects vars and the builder methods.
  2. acts as a datastore for a table row.
  The core class is designed to be extended for each of your tables so that you put the
  data logic inside the data classes.
  included is a Generator to make your configuration files and your base classes.
TXT;
const COMPOSER_DESCRIPTION = 'ORM based on PEAR::DB_DataObject ported for PHP 8.4+ and PDO';

$root = dirname(__DIR__, 2);
$check = in_array('--check', $argv, true) || in_array('check', $argv, true);

$sections = parseChangelog($root . '/CHANGELOG.md');
$current = latestRelease($sections);
if ($current === null) {
    fwrite(STDERR, "error: CHANGELOG.md has no ## [X.Y.Z] - YYYY-MM-DD section\n");
    exit(1);
}

$packageXml = renderPackage2($root, $current, $sections);
$composerJson = renderComposer($current);

if ($check) {
    $ok = true;
    $ok = diffFile($root . '/package2.xml', $packageXml, 'package2.xml') && $ok;
    $ok = diffFile($root . '/composer.json', $composerJson, 'composer.json') && $ok;
    if (!$ok) {
        fwrite(STDERR, "error: package files are stale — run scripts/release/package.sh\n");
        exit(1);
    }
    echo "package2.xml and composer.json match CHANGELOG.md\n";
    exit(0);
}

file_put_contents($root . '/package2.xml', $packageXml);
file_put_contents($root . '/composer.json', $composerJson);
echo "Wrote package2.xml and composer.json for {$current['version']}\n";

function parseChangelog(string $path): array
{
    if (!is_file($path)) {
        fwrite(STDERR, "error: missing $path\n");
        exit(1);
    }
    $sections = [];
    $current = null;
    $inFence = false;
    foreach (file($path) as $raw) {
        $line = rtrim($raw, "\n\r");
        if (str_starts_with($line, '```')) {
            $inFence = !$inFence;
            if ($current !== null) {
                $current['notes'] .= $line . "\n";
            }
            continue;
        }
        if ($inFence) {
            if ($current !== null) {
                $current['notes'] .= $line . "\n";
            }
            continue;
        }
        if (preg_match('/^## \[([^\]]+)\](?: - (Unreleased|[0-9]{4}-[0-9]{2}-[0-9]{2}))?\s*$/', $line, $m)) {
            if ($current !== null) {
                $current['notes'] = trim($current['notes']);
                $sections[] = $current;
            }
            $current = [
                'version' => $m[1],
                'date' => $m[2] ?? '',
                'notes' => '',
            ];
            continue;
        }
        if ($current !== null) {
            $current['notes'] .= $line . "\n";
        }
    }
    if ($current !== null) {
        $current['notes'] = trim($current['notes']);
        $sections[] = $current;
    }
    return $sections;
}

function latestRelease(array $sections): ?array
{
    foreach ($sections as $section) {
        if ($section['version'] === 'Unreleased') {
            continue;
        }
        if ($section['date'] === '' || $section['date'] === 'Unreleased') {
            fwrite(STDERR, "error: CHANGELOG.md section [{$section['version']}] has no date\n");
            exit(1);
        }
        return $section;
    }
    return null;
}

function xml(string $s): string
{
    return htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

function cdata(string $s): string
{
    return '<![CDATA[' . str_replace(']]>', ']]]]><![CDATA[>', $s) . ']]>';
}

function collectPhpTree(string $abs): array
{
    $dirs = [];
    $files = [];
    foreach (scandir($abs) ?: [] as $name) {
        if ($name === '.' || $name === '..') {
            continue;
        }
        $path = $abs . '/' . $name;
        if (is_dir($path)) {
            $dirs[$name] = collectPhpTree($path);
            continue;
        }
        if (is_file($path) && str_ends_with($name, '.php')) {
            $files[] = $name;
        }
    }
    ksort($dirs, SORT_STRING);
    sort($files, SORT_STRING);
    return ['dirs' => $dirs, 'files' => $files];
}

function emitPhpTree(array $tree, int $pad, string $rel): string
{
    $sp = str_repeat(' ', $pad);
    $xml = '';
    foreach ($tree['dirs'] as $name => $child) {
        $xml .= $sp . '<dir name="' . xml($name) . '">' . "\n";
        $childRel = $rel === '' ? $name : $rel . '/' . $name;
        $xml .= emitPhpTree($child, $pad + 1, $childRel);
        $xml .= $sp . '</dir>' . "\n";
    }
    foreach ($tree['files'] as $name) {
        $fullRel = $rel === '' ? $name : $rel . '/' . $name;
        if ($fullRel === 'PDO/DataObject.php') {
            $xml .= $sp . '<file name="' . xml($name) . '" role="php">' . "\n";
            $xml .= $sp . ' <tasks:replace from="@version@" to="version" type="package-info" />' . "\n";
            $xml .= $sp . '</file>' . "\n";
            continue;
        }
        $xml .= $sp . '<file name="' . xml($name) . '" role="php" />' . "\n";
    }
    return $xml;
}

function renderReleaseBlock(array $section, string $indent): string
{
    $sp = $indent;
    $notes = $section['notes'] === '' ? 'No notes.' : $section['notes'];
    return
        $sp . "<date>" . xml($section['date']) . "</date>\n" .
        $sp . "<version>\n" .
        $sp . " <release>" . xml($section['version']) . "</release>\n" .
        $sp . " <api>" . xml(API_VERSION) . "</api>\n" .
        $sp . "</version>\n" .
        $sp . "<stability>\n" .
        $sp . " <release>" . xml(STABILITY) . "</release>\n" .
        $sp . " <api>" . xml(STABILITY) . "</api>\n" .
        $sp . "</stability>\n" .
        $sp . "<license uri=\"" . xml(LICENSE_URI) . "\">LGPL</license>\n" .
        $sp . "<notes>" . cdata("\n" . $notes . "\n") . "</notes>\n";
}

function renderPackage2(string $root, array $current, array $sections): string
{
    $tree = collectPhpTree($root . '/PDO');
    $contents = emitPhpTree($tree, 4, 'PDO');

    $changelog = '';
    $seenCurrent = false;
    foreach ($sections as $section) {
        if ($section['version'] === 'Unreleased') {
            continue;
        }
        if (!$seenCurrent) {
            $seenCurrent = true;
            continue;
        }
        $changelog .= "  <release>\n" . renderReleaseBlock($section, '   ') . "  </release>\n\n";
    }

    $licence = is_file($root . '/LICENCE') ? "   <file name=\"LICENCE\" role=\"doc\" />\n" : '';
    $currentXml = renderReleaseBlock($current, ' ');
    $description = xml(DESCRIPTION);
    $name = xml(PACKAGE_NAME);
    $channel = xml(CHANNEL);
    $summary = xml(SUMMARY);
    $phpMin = xml(PHP_MIN_PEAR);

    return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!-- Generated from CHANGELOG.md by scripts/release/package.sh — do not edit. -->
<package packagerversion="1.6.1" version="2.0" xmlns="http://pear.php.net/dtd/package-2.0" xmlns:tasks="http://pear.php.net/dtd/tasks-1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://pear.php.net/dtd/tasks-1.0
http://pear.php.net/dtd/tasks-1.0.xsd
http://pear.php.net/dtd/package-2.0
http://pear.php.net/dtd/package-2.0.xsd">
 <name>{$name}</name>
 <channel>{$channel}</channel>
 <summary>{$summary}</summary>
 <description>{$description}
 </description>
 <lead>
  <name>Alan Knowles</name>
  <user>alan_k</user>
  <email>alan@roojs.com</email>
  <active>yes</active>
 </lead>
{$currentXml} <contents>
  <dir name="/">
   <dir name="PDO">
{$contents}   </dir>
{$licence}  </dir>
 </contents>
 <dependencies>
  <required>
   <php>
    <min>{$phpMin}</min>
   </php>
   <pearinstaller>
    <min>1.4.0b1</min>
   </pearinstaller>
  </required>
  <optional>
  </optional>
 </dependencies>
 <phprelease />
 <changelog>
{$changelog} </changelog>
</package>

XML;
}

function renderComposer(array $current): string
{
    $data = [
        'name' => COMPOSER_NAME,
        'type' => 'library',
        'description' => COMPOSER_DESCRIPTION,
        'keywords' => ['orm'],
        'homepage' => HOMEPAGE . '#v' . $current['version'],
        'license' => 'LGPL-3.0',
        'authors' => [
            [
                'name' => 'Alan Knowles',
                'email' => 'alan@roojs.com',
            ],
        ],
        'autoload' => [
            'psr-0' => [
                'PDO' => './',
            ],
        ],
        'require' => [
            'php' => '>=' . PHP_MIN,
        ],
        'archive' => [
            'exclude' => [
                '/scripts',
                '/tests',
                '/docs',
                '/.github',
                '/.gitignore',
                '/.gitattributes',
                '/.cursorindexingignore',
                '/package2.xml',
            ],
        ],
        'config' => [
            'secure-http' => false,
        ],
    ];
    return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
}

function diffFile(string $path, string $expected, string $label): bool
{
    $actual = is_file($path) ? file_get_contents($path) : '';
    if ($actual === $expected) {
        return true;
    }
    $tmp = tempnam(sys_get_temp_dir(), 'pdo-pkg-');
    file_put_contents($tmp, $expected);
    fwrite(STDERR, "---- $label ----\n");
    passthru('diff -u ' . escapeshellarg($path) . ' ' . escapeshellarg($tmp));
    unlink($tmp);
    return false;
}

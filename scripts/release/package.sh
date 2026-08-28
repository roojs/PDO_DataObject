#!/usr/bin/env bash
# Generate (or verify) package2.xml, composer.json, and docs/ from CHANGELOG.md
# plus the PDO/ PHP tree (via PHP_CodeDoc).
#
# Version, date, and notes come from the latest ## [X.Y.Z] section.
# API docs (.bjs / categories.json) are rebuilt by PHP_CodeDoc.
set -euo pipefail

root="$(cd "$(dirname "$0")/../.." && pwd)"
cd "${root}"

check=0
case "${1:-}" in
	-h|--help)
		cat <<'EOF'
Usage: scripts/release/package.sh [--check]

Write package2.xml and composer.json from CHANGELOG.md (version, date,
notes) and the PDO/ PHP tree, then rebuild docs/ with PHP_CodeDoc.

  --check   Exit 1 unless package files and generated docs match a
            fresh generate.
EOF
		exit 0
		;;
	--check|check)
		check=1
		;;
	'')
		;;
	*)
		echo "error: unknown option: $1" >&2
		echo "Usage: scripts/release/package.sh [--check]" >&2
		exit 1
		;;
esac

find_codedoc() {
	local cand
	if [[ -n "${PHP_CODEDOC:-}" ]]; then
		printf '%s\n' "${PHP_CODEDOC}"
		return 0
	fi
	for cand in \
		"$(cd "${root}/.." && pwd)/PHP_CodeDoc" \
		"${HOME}/gitlive/PHP_CodeDoc"
	do
		if [[ -f "${cand}/scripts/phpcodedoc" ]]; then
			printf '%s\n' "${cand}"
			return 0
		fi
	done
	return 1
}

run_codedoc() {
	local target="$1"
	local codedoc tmp ini
	codedoc="$(find_codedoc)" || {
		echo "error: PHP_CodeDoc not found (set PHP_CODEDOC or clone it next to this repo)" >&2
		exit 1
	}
	tmp="$(mktemp -d)"
	ini="${tmp}/PDO_DataObject.ini"
	mkdir -p "${target}" "${tmp}/pear" "${tmp}/cpear"
	cat > "${ini}" <<EOF
[PHP_CodeDoc]
title = "PDO_DataObject"
perDirPackages = 1
source = ${root}/PDO
destDir = ${tmp}/pear
targetJS = ${target}
makeDocBook = 0

[HTML_Template_Flexy]
compileDir = ${tmp}/cpear
forceCompile = 1
filters = Php,SimpleTags
EOF
	php "${codedoc}/scripts/phpcodedoc" "${ini}" >/dev/null
	rm -rf "${tmp}"
}

check_docs() {
	local tmpdocs rel stale=0
	tmpdocs="$(mktemp -d)"
	echo "Building docs into a temp dir to verify..."
	run_codedoc "${tmpdocs}"
	while IFS= read -r rel; do
		if ! cmp -s "${tmpdocs}/${rel}" "docs/${rel}"; then
			echo "stale: docs/${rel}" >&2
			stale=1
		fi
	done < <(cd "${tmpdocs}" && find . -type f | sed 's|^\./||' | sort)
	rm -rf "${tmpdocs}"
	if [[ "${stale}" -ne 0 ]]; then
		echo "error: docs/ are stale — run scripts/release/package.sh" >&2
		return 1
	fi
	echo "docs/ match PHP_CodeDoc output"
}

if [[ "${check}" -eq 1 ]]; then
	php scripts/release/package.php --check
	check_docs
	exit 0
fi

php scripts/release/package.php
echo "Building docs with PHP_CodeDoc..."
run_codedoc "${root}/docs"
echo "Wrote docs/ (.bjs and categories.json)"

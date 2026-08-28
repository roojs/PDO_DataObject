#!/usr/bin/env bash
# Verify the tree is ready, then tag + push. That is all.
#
# 1. Read latest ## [X.Y.Z] from CHANGELOG.md (not [Unreleased])
# 2. Exit if tag vX.Y.Z already exists (local or origin)
#    unless --retry: delete that tag locally and on origin, then continue
# 3. Verify: Unreleased is empty, clean tree, non-empty notes,
#    package2.xml, composer.json, and docs/ were generated from CHANGELOG.md
#    / PHP sources
# 4. git tag -a + git push (branch + tag) → GitHub Actions publishes
#    a GitHub Release whose notes come from CHANGELOG.md
#
# AGENTS ARE BANNED from running this script. Do not tag, push, or release
# on the user's behalf. Do not unset CURSOR_AGENT, spoof the environment,
# invoke git tag/push directly, or otherwise work around this guard.
# Only the human runs scripts/release.sh in a normal terminal.
set -euo pipefail

if [[ "${CURSOR_AGENT:-}" == "1" ]]; then
	cat >&2 <<'EOF'
error: agents are banned from running scripts/release.sh.

Do not work around this (unset CURSOR_AGENT, fake the env, call git tag/push
yourself, etc.). The human must run scripts/release.sh in a normal terminal.
EOF
	exit 1
fi

retry=0
for arg in "$@"; do
	case "${arg}" in
		--retry)
			retry=1
			;;
		-h|--help)
			cat <<'EOF'
Usage: scripts/release.sh [--retry]

Create an annotated tag from CHANGELOG.md and push it to origin.

  --retry   Delete the existing version tag locally and on origin, then
            retag HEAD and push (use after a cancelled or failed release CI run).
EOF
			exit 0
			;;
		*)
			echo "error: unknown option: ${arg}" >&2
			echo "Usage: scripts/release.sh [--retry]" >&2
			exit 1
			;;
	esac
done

root="$(cd "$(dirname "$0")/.." && pwd)"
cd "${root}"

if [[ ! -f CHANGELOG.md ]]; then
	echo "error: missing CHANGELOG.md" >&2
	exit 1
fi

if awk '
	BEGIN { u=0 }
	/^## \[Unreleased\]/ { u=1; next }
	u && /^## / { exit }
	u && /^- / { found=1; exit }
	END { exit found ? 0 : 1 }
' CHANGELOG.md; then
	echo "error: [Unreleased] still has notes — move them under ## [X.Y.Z] - YYYY-MM-DD first" >&2
	exit 1
fi

chmod +x scripts/release/changelog.sh
ver="$(scripts/release/changelog.sh version)"
tag="v${ver}"
notes="$(scripts/release/changelog.sh notes "${ver}")"

echo "CHANGELOG.md latest: ${ver}"
echo "Tag: ${tag}"
echo "---- notes ----"
echo "${notes}"
echo "---------------"

if [[ -z "${notes//[[:space:]]/}" ]]; then
	echo "error: empty notes for ${ver} — fill CHANGELOG.md first" >&2
	exit 1
fi

chmod +x scripts/release/package.sh
if ! scripts/release/package.sh --check; then
	echo "error: regenerate package files from CHANGELOG.md with scripts/release/package.sh" >&2
	exit 1
fi

if [[ -n "$(git status --porcelain)" ]]; then
	echo "error: working tree not clean — commit or stash before releasing" >&2
	git status --short >&2
	exit 1
fi

git fetch --tags origin 2>/dev/null || git fetch --tags github 2>/dev/null || true

if [[ "${retry}" -eq 1 ]]; then
	if git rev-parse -q --verify "refs/tags/${tag}" >/dev/null; then
		echo "Deleting local tag ${tag}..."
		git tag -d "${tag}"
	fi
	if git ls-remote --exit-code --tags origin "refs/tags/${tag}" >/dev/null 2>&1; then
		echo "Deleting origin tag ${tag}..."
		git push origin --delete "refs/tags/${tag}"
	elif git ls-remote --exit-code --tags github "refs/tags/${tag}" >/dev/null 2>&1; then
		echo "Deleting github tag ${tag}..."
		git push github --delete "refs/tags/${tag}"
	fi
fi

if git rev-parse -q --verify "refs/tags/${tag}" >/dev/null; then
	echo "Tag ${tag} already exists locally — nothing to do."
	echo "Re-run with --retry to delete it and retag HEAD." >&2
	exit 0
fi

if git ls-remote --exit-code --tags origin "refs/tags/${tag}" >/dev/null 2>&1 \
	|| git ls-remote --exit-code --tags github "refs/tags/${tag}" >/dev/null 2>&1; then
	echo "Tag ${tag} already exists on a remote — nothing to do."
	echo "Re-run with --retry to delete it and retag HEAD." >&2
	exit 0
fi

echo "Creating annotated tag ${tag}..."
git tag -a "${tag}" -m "${tag}"

branch="$(git rev-parse --abbrev-ref HEAD)"
echo "Pushing ${branch} and ${tag}..."
if git remote get-url github >/dev/null 2>&1; then
	git push -u github "${branch}"
	git push github "${tag}"
else
	git push -u origin "${branch}"
	git push origin "${tag}"
fi

echo "Released ${tag}. GitHub Actions will publish release notes from CHANGELOG.md."

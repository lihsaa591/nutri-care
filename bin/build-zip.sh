#!/usr/bin/env bash
# Build dist/nutri-care.zip containing only what ships to WordPress.org.
set -euo pipefail
cd "$(dirname "$0")/.."
rm -rf dist
mkdir -p dist/nutri-care
rsync -a \
	--exclude '.git' --exclude '.github' --exclude '.gitignore' --exclude '.superpowers' \
	--exclude 'dist' --exclude 'node_modules' --exclude 'vendor' --exclude 'tests' --exclude 'bin' \
	--exclude 'composer.json' --exclude 'composer.lock' --exclude 'package.json' --exclude 'package-lock.json' \
	--exclude 'phpcs.xml.dist' --exclude 'phpunit.xml.dist' --exclude '.phpunit.cache' --exclude '.DS_Store' \
	./ dist/nutri-care/
( cd dist && zip -qr nutri-care.zip nutri-care )
echo "dist/nutri-care.zip"

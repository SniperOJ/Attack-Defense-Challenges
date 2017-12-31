@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../d11wtq/boris/bin/boris
php "%BIN_TARGET%" %*

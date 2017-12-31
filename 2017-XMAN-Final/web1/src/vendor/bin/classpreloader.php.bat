@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../classpreloader/classpreloader/classpreloader.php
php "%BIN_TARGET%" %*

# Stages the Laravel app and creates eagle-academy-hostinger.zip in the project root.
# Does NOT include .env (use Hostinger env panel or: cp .env.example .env && nano .env on server).
# Upload via File Manager or SCP, extract under domains/eagleacademy.site/
# Typical Hostinger layout: move Laravel `public/*` into public_html; keep app, bootstrap, config, etc. one level above public_html (index.php already uses ../vendor).
# Usage: powershell -ExecutionPolicy Bypass -File scripts\pack-for-hostinger.ps1
# Optional: -NoVendor  (smaller zip; on SSH run: composer install --no-dev --optimize-autoloader)

param(
    [switch]$NoVendor
)

$ErrorActionPreference = "Stop"
$ProjectRoot = (Resolve-Path (Join-Path $PSScriptRoot "..")).Path
$stageName = "eagle-academy-deploy-staging"
$stage = Join-Path $ProjectRoot $stageName
$zipPath = Join-Path $ProjectRoot "eagle-academy-hostinger.zip"

$excludeTopLevel = @(
    "node_modules",
    ".git",
    ".cursor",
    ".idea",
    ".vscode",
    ".zed",
    "tests",
    $stageName,
    "eagle-academy-hostinger.zip",
    ".env",
    ".env.backup",
    ".env.production"
)

if (Test-Path $stage) {
    Remove-Item -LiteralPath $stage -Recurse -Force
}
New-Item -ItemType Directory -Path $stage | Out-Null

Get-ChildItem -LiteralPath $ProjectRoot -Force | ForEach-Object {
    if ($excludeTopLevel -contains $_.Name) {
        return
    }
    if ($_.Name -eq "vendor" -and $NoVendor) {
        return
    }
    Copy-Item -LiteralPath $_.FullName -Destination (Join-Path $stage $_.Name) -Recurse -Force
}

if (Test-Path $zipPath) {
    Remove-Item -LiteralPath $zipPath -Force
}

Compress-Archive -Path (Join-Path $stage "*") -DestinationPath $zipPath -CompressionLevel Optimal

Remove-Item -LiteralPath $stage -Recurse -Force

$sizeMb = [math]::Round((Get-Item $zipPath).Length / 1MB, 2)
Write-Host "Created $zipPath ($sizeMb MB)"

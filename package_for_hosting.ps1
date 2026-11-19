# ==============================================================
# CourseERP - InfinityFree & Live Hosting Packager
# ==============================================================
# This script bundles all required website files into a clean zip
# that is guaranteed to be under InfinityFree limits (skips .git, zip files, etc.)

$ProgressPreference = 'SilentlyContinue'
$sourceDir = $PSScriptRoot
$zipPath = Join-Path $sourceDir "upload_to_infinityfree_htdocs.zip"

Write-Host "Creating clean deployment package..." -ForegroundColor Cyan

# Remove old zip if present
if (Test-Path $zipPath) {
    Remove-Item -Path $zipPath -Force
}

# Exclude patterns for live hosting
$excludePatterns = @(
    '\.git\\',
    '\.github\\',
    'upload_to_infinityfree_htdocs\.zip',
    'stripe_1\.30\.0_windows_x86_64\.zip',
    'package-lock\.json',
    '\.wasmerignore',
    'wasmer\.toml'
)

$files = Get-ChildItem -Path $sourceDir -Recurse | Where-Object {
    $item = $_
    if ($item.PSIsContainer) { return $false }
    foreach ($pattern in $excludePatterns) {
        if ($item.FullName -match $pattern) { return $false }
    }
    return $true
}

# Add files to zip
Compress-Archive -Path $files.FullName -DestinationPath $zipPath -CompressionLevel Optimal

Write-Host "Success! Created: upload_to_infinityfree_htdocs.zip" -ForegroundColor Green
Write-Host "File Size: $([math]::round((Get-Item $zipPath).Length / 1MB, 2)) MB" -ForegroundColor Yellow
Write-Host "Extract the contents of this zip directly inside the 'htdocs' folder on InfinityFree!" -ForegroundColor Cyan

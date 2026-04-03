param(
  [string]$HostName = "127.0.0.1",
  [int]$Port = 8000
)

$workspaceRoot = Split-Path -Parent $PSScriptRoot
$phpExe = $null
$phpCommand = Get-Command php -ErrorAction SilentlyContinue

if ($phpCommand) {
  $phpExe = $phpCommand.Source
}

if (-not $phpExe) {
  $packageRoot = Join-Path $env:LOCALAPPDATA "Microsoft\\WinGet\\Packages"
  $phpPackage = Get-ChildItem $packageRoot -Directory -Filter "PHP.PHP.*" -ErrorAction SilentlyContinue |
    Sort-Object LastWriteTime -Descending |
    Select-Object -First 1

  if ($phpPackage) {
    $candidate = Join-Path $phpPackage.FullName "php.exe"
    if (Test-Path $candidate) {
      $phpExe = $candidate
    }
  }
}

if (-not $phpExe) {
  Write-Error "PHP was not found. Install it first, then run this task again."
  exit 1
}

Write-Host "Starting Loop preview on http://$HostName`:$Port"
& $phpExe -S "$HostName`:$Port" -t $workspaceRoot

@echo off
rem $Id$

rem Define Coder Format shell invocation script path.
set coderFormatPath=c:\program files\coder_format


:: ----- You should not need to edit anything below. ----- ::

if "%~1"=="" goto error
set oldpwd=%CD%
cd /d "%coderFormatPath%"

rem Check if at least one argument follows a --undo parameter.
if "%~1"=="--undo" if "%~2"=="" goto error

start "coder_format" /D "%coderFormatPath%" /B /WAIT php coder_format.php %*
goto done

:error
echo ERROR: Wrong arguments supplied. Please see usage in coder_format.php.
goto :EOF

:done
rem Jump back to original working directory.
cd /d "%oldpwd%"


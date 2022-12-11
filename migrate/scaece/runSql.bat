for %%G in (*.sql) do sqlcmd /S VMC15662E\SQLRYV /d sitce_ryv -E -i"%%G"
pause
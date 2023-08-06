git diff-index --quiet HEAD --
if [ $? -eq 1 ]; then
    git commit -m "Projeto finalizado"
else
    git commit --allow-empty -m "Projeto finalizado"
fi
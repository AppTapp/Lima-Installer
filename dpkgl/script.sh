while read line
do
echo $(cat out.log | grep "$line" | wc -l)
done < dpkgl.log


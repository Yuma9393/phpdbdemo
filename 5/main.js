function getAllStudents() {
    fetch('./list.php')
    .then((response) => {
        if (!response.ok) {
            document.getElementById('list').innerText = 'データが取得できませんでした。';    
            throw new Error("エラーが発生しました");
        }
        return response.json();
    })
    .then((json) => {
        let html = '<table border="1"><tr><th>番号</th><th>氏名</th><th>メールアドレス</th><th>誕生日</th></tr>';
        json.forEach(student => {
            html += '<tr><td>' + student.no + '</td><td>' + student.name + '</td><td>' + student.mail + '</td><td>' + student.birthday + '</td></tr>';
        })
        html += '</table>'
        document.getElementById('list').innerHTML = html;    
    })
    .catch((error) => {
        console.log(error);
    });
}

window.addEventListener("load",getAllStudents);
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
        let html = '<table border="1"><tr><th>番号</th><th>氏名</th><th>メールアドレス</th><th>誕生日</th><th>削除</th></tr>';
        json.forEach(student => {
            html += '<tr><td>' + student.no + '</td><td>' + student.name + '</td><td>' + student.mail + '</td><td>' + student.birthday + '</td><td><button type="button" onclick="deleteStudent(' + student.no + ')">削除</button></td></tr>';
        })
        html += '</table>'
        document.getElementById('list').innerHTML = html;    
    })
    .catch((error) => {
        console.log(error);
    });
}

function addStudent() {
    const formData = new FormData(document.getElementById('student'));
    fetch('./add.php', {
        method: 'POST',
        body: formData 
    })
    .then((response) => {
        if (!response.ok) {
            document.getElementById('message').innerText = 'データが登録できませんでした。';    
            throw new Error("エラーが発生しました");
        } else {
            getAllStudents();
            document.getElementById('message').innerText = 'データが登録されました。';
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

function deleteStudent(no) {
    const formData = new FormData();
    formData.append('no', no);
    fetch('./delete.php', {
        method: 'POST',
        body: formData 
    })
    .then((response) => {
        if (!response.ok) {
            document.getElementById('message').innerText = 'データが削除できませんでした。';    
            throw new Error("エラーが発生しました");
        } else {
            getAllStudents();
            document.getElementById('message').innerText = 'データが削除されました。';
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

function formSwitch() {
    hoge = document.getElementsByName('maker')
    if (hoge[0].checked) {
        document.getElementById('addform').style.display = "";
        document.getElementById('searchform').style.display = "none";
        document.getElementById('message').innerText = '';
        document.getElementById('student').reset();
    } else if (hoge[1].checked) {
        document.getElementById('addform').style.display = "none";
        document.getElementById('searchform').style.display = "";
        document.getElementById('message').innerText = '';
        document.getElementById('student').reset();

    } else {
        document.getElementById('addform').style.display = "none";
        document.getElementById('searchform').style.display = "none";
        document.getElementById('message').innerText = '';
    }
}

function searchStudent() {
    const formData = new FormData(document.getElementById('student'));
    fetch('./search.php', {
        method: 'POST',
        body: formData 
    })
    .then((response) => {
        if (!response.ok) {
            document.getElementById('message').innerText = 'データが検索できませんでした。';    
            throw new Error("エラーが発生しました");
        } else {
            getAllStudents();
            document.getElementById('message').innerText = 'データが検索されました。';
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

window.addEventListener("load",getAllStudents);
window.addEventListener('load', formSwitch);


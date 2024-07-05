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
        let html = '<table border="1"><tr><th>番号</th><th>氏名</th><th>メールアドレス</th><th>誕生日</th><th>削除</th><th>更新</th></tr>';
        json.forEach(student => {
            html += '<tr><td>' + student.no + '</td><td>' + student.name + '</td><td>' + student.mail + '</td><td>' + student.birthday + '</td><td><button type="button" onclick="deleteStudent(' + student.no + ')">削除</button></td><td><button type="button" onclick="updateStudent(' + student.no + ')">更新</button></td></tr>';
        })
        html += '</tbody></table>';
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
            document.getElementById('student').innerHTML = '';
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
            document.getElementById('student').innerHTML = '';
            document.getElementById('message').innerText = 'データが削除されました。';
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

function searchStudent(){
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
            //getAllStudents();
            document.getElementById('message').innerText = 'データが検索されました。';
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

function referenceStudent(no){
    const formData = new FormData();
    formData.append('no', no);
    fetch('./reference.php', {
        method: 'POST',
        body: formData 
    })
    .then((response) => {
        if (!response.ok) {
            document.getElementById('message').innerText = 'データベースに接続できませんでした。';    
            throw new Error("エラーが発生しました");
        }
        return response.json();
    })
    .then((json) => {
        let student = document.getElementById("student");

        Object.keys(json).forEach(function(value) {
            student.elements[value].value = this[value];
        }, json)
    })
    .catch((error) => {
        console.log(error);
    });
}

/*
    ToDoリスト
    updateStudent()を作成する
    searchStudent()を作成する
*/

function updateStudent(no) {
    const formData = new FormData(document.getElementById('student'));
    formData.append('no', no);
    fetch('./update.php', {
        method: 'POST',
        body: formData 
    })
    .then((response) => {
        if (!response.ok) {
            document.getElementById('message').innerText = 'データを更新できませんでした。';    
            throw new Error("エラーが発生しました");
        } else {
            getAllStudents();
            document.getElementById('message').innerText = 'データが更新されました。';
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

function insertForm(mode, no){
    let student = 'ID：<input type="number" name="no" required/><br>氏名：<input type="text" name="name" required/><br>メールアドレス：<input type="email" name="mail" required/><br>生年月日：<input type="date" name="birthday" required/><br>';
    if(mode === "reference"){
        referenceStudent(no);

        student += '<button type="button" onclick="updateStudent(' + no + ')">更新</button>';
        student += '<button type="button" onclick="deleteStudent(' + no + ')">削除</button>';
    }
    if(mode === "entry"){
        student += '<button type="button" onclick="addStudent()">登録</button>';
    }
    if(mode === "search"){
        student += '<button type="button" onclick="searchStudent()">検索</button>';
    }
    document.getElementById("student").innerHTML = student;
    //console.log(student);
}

window.addEventListener("load",getAllStudents);
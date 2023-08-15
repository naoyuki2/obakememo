
async function GetDatabaseData(func, args) {
    const url = "http://localhost/SQL.php";
    const params = new URLSearchParams({
        mode: 'get',
        func: func,
        args: JSON.stringify(args)
    })
    try {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: params
        })
        if (!res.ok) {
            throw new Error('Network response was not ok')
        }
        const data = await res.json()
        return data
    } catch (error) {
        console.error('Error fetching data:', error)
    }

}

async function EditDatabaseData(func, args) {
    const url = "http://localhost/SQL.php";
    const params = new URLSearchParams({
      mode: 'edit',
      func: func,
      args: JSON.stringify(args)
    });
  
    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: params
      });
  
      if (!res.ok) {
        throw new Error('Network response was not ok');
      }
  
      console.log("リクエストが成功しました");
    } catch (error) {
      console.error('Error editing data:', error);
      console.log("リクエストが失敗しました");
    }
  }
  
export { GetDatabaseData, EditDatabaseData }


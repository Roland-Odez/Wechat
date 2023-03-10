// search for users on search bar
searchBar.onkeyup = async (e) => {
    usersList.classList.add("active")
    const fetchData = await fetch("./php/users.php", {
        method: 'POST',
        body: JSON.stringify({
            searchBar: e.target.value
        })
    })
    const data = await fetchData.json()
    usersList.innerHTML = data.result;

}

// get users chats when not searching for users in search bar
if (!searchBar.value.length) {
    setInterval(async () => {
        if (!usersList.classList.contains("active")) {
            const fetchData = await fetch("./php/get_users_chats.php", {
                method: 'GET'
            })
            const data = await fetchData.json()
            usersList.innerHTML = data.result;
        }
    }, 300)
}
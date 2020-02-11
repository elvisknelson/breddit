function loadPosts() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText === "")
            {
                document.getElementsByClassName('loadmore').innerHTML = "Nothing more to show"
            }
            else
            {
                document.getElementById('main').innerHTML += this.responseText;
            }
        }
      };

    xmlhttp.open("GET", "utility/getPosts.php");
    xmlhttp.send(null);
}
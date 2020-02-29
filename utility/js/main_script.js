if (window.XMLHttpRequest) {
  xmlhttp = new XMLHttpRequest();
} else {
  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

function addVote(postId, voteType) {
  var url = 'utility/add_vote.php';
  var params = 'postId=' + postId + "&voteType=" + voteType;
  xmlhttp.open('POST', url, true);

  xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xmlhttp.onreadystatechange = function() {
      if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        
      }
  }
  xmlhttp.send(params);
}

function loadPosts(mouseEvent, result = "?page") {
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          if(this.responseText === "") {
              document.getElementById('load').innerHTML = "Nothing more to show";
          } else {
              document.getElementById('main').innerHTML += this.responseText;
              document.getElementById("hideAll").style.display = "none";
          }
      }
    };

  xmlhttp.open("GET", "utility/get_posts.php" + result);
  xmlhttp.send(null);
}

function main()
{
  addEventListeners();
  loadPosts(null, "?initial");
}

function addEventListeners()
{
  document.getElementById("load").addEventListener("click", loadPosts);
}

function focusTextbox()
{
    document.getElementById('loginuser').focus();
}

document.addEventListener("DOMContentLoaded", main);













































// function updateRecord(id, voteType)
// {
//   if(voteType == 1 && document.getElementById('uv'+id) == "javascript:")
//   {
//     jQuery.ajax({
//       type: "POST",
//       url: "utility/process_post.php",
//       data: { 'vote': id, 'votetype': voteType },
//       cache: false,
//       success: function(response)
//       {
//        var num = parseInt(document.getElementById(id).innerHTML);
       
//        if(document.getElementById('dv'+id).href == "javascript:")
//        {
//          num += 1;
//        }
//        else
//        {
//          num += 2;
//        }
       
//        a = document.getElementById('dv'+id);
//        a.href = "javascript:";
//        document.getElementById('uv'+id).removeAttribute('href');
//        document.getElementById('dv'+id).style.color = "rgb(0, 123, 255)";
//        document.getElementById('uv'+id).style.color = "orange";
//        document.getElementById('dv'+id).removeAttribute('href');
//        document.getElementById(id).innerHTML = num;
//       }
//     });
//   }
//   if(voteType == 2 && document.getElementById('dv'+id) == "javascript:")
//   {
//     jQuery.ajax({
//       type: "POST",
//       url: "utility/process_post.php",
//       data: { 'vote': id, 'votetype': voteType },
//       cache: false,
//       success: function(response)
//       {
//        var num = parseInt(document.getElementById(id).innerHTML);
       
//        if(document.getElementById('uv'+id).href == "javascript:")
//        {
//          num -= 1;
//        }
//        else
//        {
//          num -= 2;
//        }
       
//        a = document.getElementById('uv'+id);
//        a.href = "javascript:";
//        document.getElementById('uv'+id).removeAttribute('href');
//        document.getElementById('uv'+id).style.color = "rgb(0, 123, 255)";
//        document.getElementById('dv'+id).style.color = "orange";
//        document.getElementById('dv'+id).removeAttribute('href');
//        document.getElementById(id).innerHTML = num;
//       }
//     });
//   }
     
// }

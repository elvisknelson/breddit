var locked = false;
function CreateComment(id, userid, username) {
    if (!locked) {
        locked = true;
        DisplayComment(id, userid, username);
        setTimeout(unlock, 2000);
    }
}

function unlock () {
    locked = false;
}

function DisplayComment(id, userid, username){
  var content = document.getElementById('commentfield').value;
  
  if(content.trim() != '')
  {
    jQuery.ajax({
      type: "POST",
      url: "utility/process_post.php",
      data: { 'superpostid': id, 'user': userid, 'content' : content },
      cache: false,
      success: function(response) //Adding Comment Box using javascript
      {
        var contentDiv = document.getElementById('content');

        var mainDiv = document.createElement('div');
        var voteDiv = document.createElement('div');
        var flexDiv = document.createElement('div');

        var submittedDiv = document.createElement('div');
        var postDiv = document.createElement('div');
        var commentDiv = document.createElement('div');

        var voteLink1 = document.createElement('a');
        var voteLink2 = document.createElement('a');

        var submittedP = document.createElement('p');
        var submittedA = document.createElement('a');
        var postP = document.createElement('p');

        var commentP = document.createElement('p');

        var commentA1 = document.createElement('a');
        var commentA2 = document.createElement('a');
        var commentA3 = document.createElement('a');
        var commentA4 = document.createElement('a');
        var commentA5 = document.createElement('a');
        var commentA6 = document.createElement('a');

        mainDiv.setAttribute('class', 'comment');
        voteDiv.setAttribute('class', 'votes');
        flexDiv.setAttribute('class', 'flexdiv');

        submittedDiv.setAttribute('class', 'submitted');
        postDiv.setAttribute('class', 'postheader');
        commentDiv.setAttribute('class', 'comments');


        voteLink1.setAttribute('href', 'javascript:');
        voteLink1.setAttribute('class', 'fa fa-caret-up');
        voteLink1.setAttribute('style', 'font-size:25px');

        voteLink2.setAttribute('href', 'javascript:');
        voteLink2.setAttribute('class', 'fa fa-caret-down');
        voteLink2.setAttribute('style', 'font-size:25px');

        voteDiv.appendChild(voteLink1);
        voteDiv.appendChild(voteLink2);

        postP.innerHTML = content;
        
        submittedA.setAttribute('href', 'userindex.php?username='+username);
        submittedA.innerHTML = username;
        submittedP.appendChild(submittedA);
        submittedP.innerHTML += " 1 points";

        submittedDiv.appendChild(submittedP);
        postDiv.appendChild(postP);
        
        commentA1.setAttribute('href', 'javascript:');
        commentA2.setAttribute('href', 'javascript:');
        commentA3.setAttribute('href', 'javascript:');
        commentA4.setAttribute('href', 'javascript:');
        commentA5.setAttribute('href', 'javascript:');
        commentA6.setAttribute('href', 'javascript:');

        commentA1.innerHTML = "permalink ";
        commentA2.innerHTML = "embed ";
        commentA3.innerHTML = "save ";
        commentA4.innerHTML = "save-RES ";
        commentA5.innerHTML = "report ";
        commentA6.innerHTML = "reply ";

        commentP.appendChild(commentA1);
        commentP.appendChild(commentA2);
        commentP.appendChild(commentA3);
        commentP.appendChild(commentA4);
        commentP.appendChild(commentA5);
        commentP.appendChild(commentA6);
        commentDiv.appendChild(commentP);

        flexDiv.appendChild(submittedDiv);
        flexDiv.appendChild(postDiv);
        flexDiv.appendChild(commentDiv);

        mainDiv.appendChild(voteDiv);
        mainDiv.appendChild(flexDiv);

        contentDiv.appendChild(mainDiv);

        document.getElementById("commentfield").value = "";
      }
    });
  } else {
    content = document.getElementById('commentfield');
    content.setAttribute('placeholder', 'Comment cannot be blank');
  }
}
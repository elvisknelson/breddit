function UpdateRecord(id, voteType)
{
  if(voteType == 1 && document.getElementById('uv'+id) == "javascript:")
  {
    jQuery.ajax({
      type: "POST",
      url: "process_post.php",
      data: { 'vote': id, 'votetype': voteType },
      cache: false,
      success: function(response)
      {
       var num = parseInt(document.getElementById(id).innerHTML);
       
       if(document.getElementById('dv'+id).href == "javascript:")
       {
         num += 1;
       }
       else
       {
         num += 2;
       }
       
       a = document.getElementById('dv'+id);
       a.href = "javascript:";
       document.getElementById('uv'+id).removeAttribute('href');
       document.getElementById(id).innerHTML = num;
      }
    });
  }
  if(voteType == 2 && document.getElementById('dv'+id) == "javascript:")
  {
    jQuery.ajax({
      type: "POST",
      url: "process_post.php",
      data: { 'vote': id, 'votetype': voteType },
      cache: false,
      success: function(response)
      {
       var num = parseInt(document.getElementById(id).innerHTML);
       
       if(document.getElementById('uv'+id).href == "javascript:")
       {
         num -= 1;
       }
       else
       {
         num -= 2;
       }
       
       a = document.getElementById('uv'+id);
       a.href = "javascript:";
       document.getElementById('dv'+id).removeAttribute('href');
       document.getElementById(id).innerHTML = num;
      }
    });
  }
     
}
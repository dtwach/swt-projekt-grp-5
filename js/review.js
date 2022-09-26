var user_picture = document.getElementById('user_picture');
user_picture.addEventListener('click', function() {
    document.location.href = 'profile.php?id=' + user_picture.name;
});

var content_picture = document.getElementById('content_picture');
content_picture.addEventListener('click', function() {
  document.location.href = 'content.php?id=' + content_picture.name;
});
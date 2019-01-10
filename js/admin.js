function deleteFeed(feed) {
  var validation = confirm('Do you really want to delete this feed ?');
  if (validation)
    window.location = window.location.origin+window.location.pathname+'?action=removeFeed&feed='+feed;
}

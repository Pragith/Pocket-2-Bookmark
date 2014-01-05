function import_pocket(){
	/*
	chrome.bookmarks.create({'parentId': bookmarksBar.id,
	                         'title': 'Extension bookmarks'},
	                        function(newFolder) {
	  console.log("added folder: " + newFolder.title);
	});

	chrome.bookmarks.create({'parentId': extensionsFolderId,
	                         'title': 'Extensions doc',
	                         'url': 'http://code.google.com/chrome/extensions'});
	console.log("Created");
	*/
	pocket = $.parseJSON($("#pocket_json").val());
	$.each(pocket, function(i,item){
		console.log("Title: "+item['title'])
		console.log("URL: "+item['url'])
	})
}


function init(){
	document.getElementById("import_pocket").addEventListener("click",import_pocket);
}

window.addEventListener("load", init);

<!DOCTYPE HTML>
<html>
<head>
<title>PDF Page Counter</title>
<style>
.example {
	padding: 10px;
	border: 1px solid #ccc
}

#drop_zone {
	border: 2px dashed #bbb;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	padding: 25px;
	text-align: center;
	font: 20pt bold, "Vollkorn";
	color: #bbb
}
</style>
<script src="pdf-js/build/pdf.js"></script>
</head>
<body>
<div class="example">
<div id="drop_zone">Drop files here</div>
<output id="list"></output>
<script>
  function handleFileSelect(evt) {
    evt.stopPropagation();
    evt.preventDefault();

    var files = evt.dataTransfer.files; // FileList object.

    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = files[i]; i++) {
      if(f.type.match('application/pdf'))
      {
          output.push('<li><strong>', escape(f.name), '</strong></li>');
      }
    }
    document.getElementById('list').innerHTML = '<ol>' + output.join('') + '</ol>';
  }

  function handleDragOver(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
  }

  // Setup the dnd listeners.
  var dropZone = document.getElementById('drop_zone');
  dropZone.addEventListener('dragover', handleDragOver, false);
  dropZone.addEventListener('drop', handleFileSelect, false);
</script>
</div>
</body>
</html>
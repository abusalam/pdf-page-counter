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
	var Count=0;
	for (var i = 0, f; f = files[i]; i++) {
		open(f,"numPages"+i);
		if(f.type.match('application/pdf')) {
			Count++;
			output.push('<tr><td>',Count,'</td><td><strong>', escape(f.name), '</strong></td><td><span id="numPages',i,'">Calculating...</span></td></tr>');
		}
	}
	document.getElementById('list').innerHTML = '<table>' + output.join('') + '</table>';
}
function handleDragOver(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}
function open(f,ElementID) {
	var reader = new FileReader();
	reader.onloadend = function(evt) {
		if(evt.target.readyState == FileReader.DONE) { // DONE == 2
			PDFJS.workerSrc ="pdf.js";
			PDFJS.getDocument(evt.target.result).then(function(pdf) {
				document.getElementById(ElementID).innerHTML = pdf.numPages.toString();
			});
		}
	};
	// Read in the pdf file as a arrayBuffer.
	reader.readAsArrayBuffer(f);
}
if(window.File && window.FileReader && window.FileList && window.Blob) {
	var dropZone = document.getElementById('drop_zone');
	dropZone.addEventListener('dragover', handleDragOver, false);
	dropZone.addEventListener('drop', handleFileSelect, false);
} 
else {
	alert('This application not supported in this browser.');
}

</script>
</div>
</body>
</html>

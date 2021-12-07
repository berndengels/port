class Editor {
	create(selector, paramName, uploadURL) {
		let toolBars = {
			'default': {
				'buttons': [
					['alignLeft', 'alignCenter','alignRight', 'alignJustify'],
					['bold', 'italic', 'underline', 'strikeThrough', 'fontSize'],
					['inlineClass', 'inlineStyle', 'clearFormatting'],
					['formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'outdent', 'indent', 'quote'],
					['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'fontAwesome', 'specialCharacters', 'insertHR'],
					['save', 'undo', 'redo', 'fullscreen', 'spellChecker', 'selectAll', 'html', 'help'],
				]
			},
		};
		let editor =  new FroalaEditor(selector, {
			documentReady: true,
			height: 300,
			tabIndex: 1,
			iFrame: true,
			language: 'de',
			spellcheck: true,
			toolbarButtons: toolBars.default.buttons,
			imageUploadParam: paramName,
			imageUploadURL: uploadURL,
			imageUploadParams: {
				id: 'widget'
			},
			imageUploadMethod: 'POST',
			imageMaxSize: 5 * 1024 * 1024,
			imageAllowedTypes: ['jpeg', 'jpg', 'png'],
			'image.uploaded': function (response) {
				// Image was uploaded to the server.
			},
			'image.inserted': function ($img, response) {
				// Image was inserted in the editor.
			},
			'image.error': function (error, response) {
				console.error(error);
/*
				// Bad link.
				if (error.code == 1) { ... }
				// No link in upload response.
				else if (error.code == 2) { ... }
				// Error during image upload.
				else if (error.code == 3) { ... }
				// Parsing response failed.
				else if (error.code == 4) { ... }
				// Image too text-large.
				else if (error.code == 5) { ... }
				// Invalid image type.
				else if (error.code == 6) { ... }
				// Image can be uploaded only to same domain in IE 8 and IE 9.
				else if (error.code == 7) { ... }
				// Response contains the original server response to the request if available.
*/
			},
		});
		return editor;
	}
}
export default Editor;

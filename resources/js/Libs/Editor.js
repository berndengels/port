class Editor {
	create(selector, paramName, uploadURL) {
		let editor = tinymce.init({
			selector: selector,  // change this value according to the HTML
//			toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent'
		});

		return editor;
	}
}

export default Editor;

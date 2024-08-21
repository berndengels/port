import { Dropzone } from "dropzone";

class MyDropzone {
	create(selector = '#dropzone', paramName = 'image', model_type, model_id, uploadURL = null, files = null) {
		Dropzone.autoDiscover = false;
		const dropzone = new Dropzone(selector, {
					url: uploadURL,
					paramName: paramName,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					init: function () {
						this.on("sending", (file, xhr, formData) => {
							formData.append('model_type', model_type);
							formData.append('model_id', model_id);
						});
					},
					maxFilesize: 10,
					parallelUploads: 1,
					maxFiles: 3,
					method: 'post',
					acceptedFiles: 'image/*',
					addRemoveLinks: true,
					dictRemoveFile: 'Datei löschen',
					dictCancelUpload: 'Hochladen abbrechen',
					dictDefaultMessage: 'Bildatei hier reinziehen',
				})
				.on('removedfile', file => {
					$.ajax({
						url: '/api/files/'+ file.id,
						type: 'delete',
						success: (resp) => {
							if(resp) {
								console.info("resp", resp)
							}
						},
						error: (err) => console.error(err)
					});
				})
		;
		if(files) {
			$.each(files, (i, item) => {
				dropzone.displayExistingFile(item, item.url)
			});
		}

		return dropzone;
	}
}

export default MyDropzone;

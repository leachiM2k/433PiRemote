var page = {
	bindClickOnEditButton: function () {
		$('.edit').click(function () {

            // reset previous settings
            $('#editForm .enabledRemotes .dragremote').appendTo($('#editForm .availableRemotes'));

            var rowId = $(this).data("id");
			var name = $('#entry' + rowId + ' .entryName').text().trim();
			var delay = $('#entry' + rowId + ' .entryDelay').text().trim();
            var remotes = $('#entry' + rowId + ' .entryRemote').map(function(index, el) { return $(el).data('id') }).toArray();

            $('#editForm .availableRemotes .dragremote').filter(function(index, el) {
                return remotes.indexOf($(el).data('id')) !== -1;
            }).appendTo($('#editForm .enabledRemotes'));

			$('#editForm').modal();
			$('#editId').val(rowId);
			$('#editName').val(name);
			$('#editDelay').val(delay);
		});
	},

    bindDoubleClickOnRemote: function() {
        $('#editForm .dragremote').click(function () {
            var parent = $(this).parent('.connected');
            if(parent == null) return;
            if(parent.hasClass('availableRemotes')) {
                $(this).appendTo($('#editForm .enabledRemotes'));
            } else if(parent.hasClass('enabledRemotes')) {
                $(this).appendTo($('#editForm .availableRemotes'));
            }
        });
    },

    bindClickOnEditSaveButton: function () {
        $('#editSave').click(function () {
            $('#editForm .availableRemotes .dragremote input').remove();
        });
    },

    enableSortableRemotes: function() {
        $('#editForm .connected').sortable({ connectWith: '.connected' });
    }
};

$(document).ready(function () {
    page.enableSortableRemotes();
	page.bindClickOnEditButton();
    page.bindClickOnEditSaveButton();
    page.bindDoubleClickOnRemote();
});

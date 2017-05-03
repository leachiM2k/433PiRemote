var page = {
	newDipSwitch: null,
	editDipSwitch: null,

	addDipSwitchesToOverviewEntries: function () {
		$('.entrySystem').each(function (count, element) {

			var dipSwitch = new DIPSwitch({
				changeable: false,
				values: $(element).text().trim(),
				onSwitched: function () {
					$(element).text(this.getValuesAsString());
				}
			});
			dipSwitch.insertBefore($(element));
			dipSwitch.syncValuesToDip();
		});
	},

	setEditSystemToDipSwitch: function () {
		this.editDipSwitch.setValues($('#editSystem').val());
		this.editDipSwitch.syncValuesToDip();
	},

	addDipSwitchToEditView: function () {
		this.editDipSwitch = new DIPSwitch({
			changeable: true,
			onSwitched: function () {
				$('#editSystem').val(this.getValuesAsString());
			}
		});

		$('#editSystemDip').html("");
		this.editDipSwitch.insertInside($('#editSystemDip'));
	},

	bindClickOnEditButton: function () {
		$('.edit').click(function () {

			var rowId = $(this).data("id");
			var name = $('#entry' + rowId + ' .entryName').text().trim();
			var system = $('#entry' + rowId + ' .entrySystem').text().trim();
			var unit = $('#entry' + rowId + ' .entryUnit').text().trim();
			var inverseAction = $('#entry' + rowId + ' .entryInverseAction').text().trim() != "";

			$('#editForm').modal();
			$('#editId').val(rowId);
			$('#editName').val(name);
			$('#editSystem').val(system);
			$('#editUnit').val(unit);
			$('#editInverseAction').prop('checked', inverseAction);

			page.setEditSystemToDipSwitch();
		});
	},

	bindKeyUpOnEditSystemText: function () {
		$('#editSystem').keyup(jQuery.proxy(this.setEditSystemToDipSwitch, this));
	},


	setNewSystemToDipSwitch: function () {
		this.newDipSwitch.setValues($('#newSystem').val());
		this.newDipSwitch.syncValuesToDip();
	},

	addDipSwitchToNewView: function () {
		this.newDipSwitch = new DIPSwitch({
			changeable: true,
			onSwitched: function () {
				$('#newSystem').val(this.getValuesAsString());
			}
		});

		$('#newSystemDip').html("");
		this.newDipSwitch.insertInside($('#newSystemDip'));
	}

};

$(document).ready(function () {
	page.addDipSwitchesToOverviewEntries();

	page.addDipSwitchToEditView();
	page.bindClickOnEditButton();
	page.bindKeyUpOnEditSystemText();

	page.addDipSwitchToNewView();
	page.setNewSystemToDipSwitch();

});

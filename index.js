$( document ).ready(function() {
	$('.entrySystem').each(function(count, element) {
		
		var dipSwitch = new DIPSwitch({
			changeable: false,
			values: $(element).text().trim(),
			onSwitched: function() {
				$(element).text(this.getValuesAsString());
			}
		});
		dipSwitch.insertBefore($(element));
		dipSwitch.syncValuesToDip();
	});
	
	
	var editDipSwitch = new DIPSwitch({
		changeable: true,
		onSwitched: function() {
			$('#editSystem').val(this.getValuesAsString());
		}
	});
	$('#editSystemDip').html("");
	editDipSwitch.insertInside($('#editSystemDip'));

	var setEditSystemToDipSwitch = function() {
		editDipSwitch.setValues($('#editSystem').val());
		editDipSwitch.syncValuesToDip();
	};
	
	$('.edit').click(function() {
		
		var rowId = $(this).data("id");
		var name = $('#entry'+rowId+' .entryName').text().trim();
		var system = $('#entry'+rowId+' .entrySystem').text().trim();
		var unit = $('#entry'+rowId+' .entryUnit').text().trim();
		
		$('#editForm').modal();
		$('#editName').val(name);
		$('#editSystem').val(system);
		$('#editUnit').val(unit);

		setEditSystemToDipSwitch();
	});
	
	$('#editSystem').keyup(setEditSystemToDipSwitch);
	
});

function DIPSwitch(options) {
	
	this.values = [];
	
	this.htmlTemplate = $('<div class="dip-wrapper">' +
		'<div class="tl">ON</div><div class="tr">DIP</div>' +
	  	'<div class="switch-wrapper">' +
		  	'<div class="switch"><div class="knob tl" rel="0"></div><div class="number">1</div></div>' +
		  	'<div class="switch"><div class="knob tl" rel="1"></div><div class="number">2</div></div>' +
		  	'<div class="switch"><div class="knob tl" rel="2"></div><div class="number">3</div></div>' +
		  	'<div class="switch"><div class="knob tl" rel="3"></div><div class="number">4</div></div>' +
		  	'<div class="switch"><div class="knob tl" rel="4"></div><div class="number">5</div></div>' +
		'</div>' +
	  '</div>');
	
	this.onSwitched = function() {};
	
	this.changeable = true;
	
	if(typeof(options) != "undefined")
	{
		if(typeof(options.values) != "undefined")
			this.setValues(options.values);
		if(typeof(options.onSwitched) != "undefined")
			this.onSwitched = options.onSwitched;
		if(typeof(options.changeable) != "undefined")
			this.changeable = options.changeable;
	}

	if(this.changeable)
	{
		this.htmlTemplate.find('.knob').click($.proxy(this.bindKnobEvent, this));
		this.htmlTemplate.find('.switch').addClass('changeable');
	}
	
}

DIPSwitch.prototype.bindKnobEvent = function(event) {
	this.setValue($(event.currentTarget).attr('rel'), !this.values[$(event.currentTarget).attr('rel')]);
	this.syncValuesToDip();
	this.onSwitched();
};

DIPSwitch.prototype.onSwitched = this.onSwitched;

DIPSwitch.prototype.getValues = function()
{
	return this.values;
};

DIPSwitch.prototype.getValuesAsString = function()
{
	var stringRepresentation = "";
	for(var position = 0; position < this.values.length; position++)
	{
		stringRepresentation += (this.values[position] ? "1" : "0");
	}
	return stringRepresentation;
};

DIPSwitch.prototype.setValues = function(values)
{
	for(var position = 0; position < values.length; position++)
	{
		this.setValue(position, values[position]);
	}
};

DIPSwitch.prototype.setValue = function(position, value)
{
	if(typeof(value) == "boolean")
	{
		this.values[position] = value;
	}
	else if(typeof(value) == "string" && value.length == 1)
	{
		this.values[position] = (value == "1");
	}
};

DIPSwitch.prototype.setDipValues = function(values)
{
	for(var position = 0; position < values.length; position++)
	{
		this.setDipValue(position, values[position]);
	}
};

DIPSwitch.prototype.setDipValue = function(position, value)
{
	if(typeof(value) == "boolean")
	{
		var knob = this.htmlTemplate.find('.switch .knob')[position];
		if(typeof(knob) != "undefined")
		{
			$(knob).removeClass('tl');
			$(knob).removeClass('bl');
			
			if(value)
			{
				$(knob).addClass('tl');
			}
			else
			{
				$(knob).addClass('bl');
			}
		}
	}
};

DIPSwitch.prototype.insertBefore = function(element)
{
	$(this.htmlTemplate).insertBefore(element);
};

DIPSwitch.prototype.insertAfter = function(element)
{
	$(this.htmlTemplate).insertAfter(element);
};

DIPSwitch.prototype.syncValuesToDip = function()
{
	this.setDipValues(this.values);
};

$( document ).ready(function() {
	$('.system').each(function(count, element) {
		
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
	
	$('.edit').click(function() {
		
		$('#editForm').modal();
		
	});
});

function DIPSwitch(options) {
	
	this.values = [];

	this.onSwitched = function() {};
	
	this.changeable = true;
	
	this.switchesCount = 5;
	
	if(typeof(options) != "undefined")
	{
		if(typeof(options.values) != "undefined")
			this.setValues(options.values);
		if(typeof(options.onSwitched) != "undefined")
			this.onSwitched = options.onSwitched;
		if(typeof(options.changeable) != "undefined")
			this.changeable = options.changeable;
		if(typeof(options.switchesCount) != "undefined")
			this.switchesCount = options.switchesCount;
	}
	
	var html = '<div class="dip-wrapper">' +
		'<div class="tl">ON</div><div class="tr">DIP</div>' +
		'<div class="switch-wrapper">';
	for(var i = 0; i < this.switchesCount; i++)
	{
		html += '<div class="switch"><div class="knob tl" rel="'+i+'"></div><div class="number">'+(i+1)+'</div></div>';
	}
	html += '</div>' +
	  '</div>';
	
	this.htmlTemplate = jQuery(html);

	if(this.changeable)
	{
		this.htmlTemplate.find('.knob').click(jQuery.proxy(this.bindKnobEvent, this));
		this.htmlTemplate.find('.switch').addClass('changeable');
	}
	
}

DIPSwitch.prototype.bindKnobEvent = function(event) {
	this.setValue(jQuery(event.currentTarget).attr('rel'), !this.values[jQuery(event.currentTarget).attr('rel')]);
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
	if(values.length != this.switchesCount) return;
	
	for(var position = 0; position < values.length; position++)
	{
		this.setValue(position, values[position]);
	}
};

DIPSwitch.prototype.setValue = function(position, value)
{
	if(value >= this.switchesCount) return;
	
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
			jQuery(knob).removeClass('tl');
			jQuery(knob).removeClass('bl');
			
			if(value)
			{
				jQuery(knob).addClass('tl');
			}
			else
			{
				jQuery(knob).addClass('bl');
			}
		}
	}
};

DIPSwitch.prototype.insertBefore = function(element)
{
	jQuery(this.htmlTemplate).insertBefore(element);
};

DIPSwitch.prototype.insertAfter = function(element)
{
	jQuery(this.htmlTemplate).insertAfter(element);
};

DIPSwitch.prototype.insertInside = function(element)
{
	jQuery(this.htmlTemplate).appendTo(element);
};

DIPSwitch.prototype.syncValuesToDip = function()
{
	this.setDipValues(this.values);
};

Drupal.behaviors.myModuleAccordions = {
    attach: function(context, settings) {
// add accordions to all h3 elements wrapped in a div with a class of accordion
        jQuery('.accordion').accordion();
    }
};

Drupal.behaviors.myModuleDatepicker = {
    attach: function(context, settings) {
        // add the jQuery UI datepicker to all inputs with a class of datepicker
        jQuery('.datepicker').datepicker();
    }
};

Drupal.behaviors.myModuleDialog = {
    attach: function(context, settings) {
        // add the jQuery UI dialog to all elements with id of dialog
        jQuery('.dialog').dialog();
    }
};


Drupal.behaviors.myModuleDraggable = {
    attach: function(context, settings) {
        // make all elements with a class of draggable, well... draggable...
        jQuery('.draggable').draggable();
    }
};

/*
 Drupal.behaviors.myModuleDroppable = {
 attach: function(context, settings) {
 // make all elements with an id of droppable, well... droppable...
 jQuery(".droppable").droppable({
 drop: function(event, ui) {
 $(this)
 .addClass("ui-state-highlight")
 .find("p")
 .html("Dropped!");
 }
 });
 }
 };
 */

function dgd7progressbarUpdate() {
    var progress;
    progress = jQuery("#progressbar").progressbar("value");
    if (progress < 100) {
        jQuery(".progressbar").progressbar("value", progress + 5);
        setTimeout(dgd7progressbarUpdate, 500);
    }
}

Drupal.behaviors.dgd7progressbar = {
    attach: function(context, settings) {
        jQuery(".progressbar").progressbar({value: 1});
        setTimeout(dgd7progressbarUpdate, 500);
    }
};

Drupal.behaviors.dgd7resizable = {
    attach: function(context, settings) {
        jQuery('.resizable').resizable();
    }
};


Drupal.behaviors.dgd7selectable = {
    attach: function(context, settings) {
        jQuery('.selectable').selectable();
    }
};


Drupal.behaviors.dgd7slider = {
    attach: function(context, settings) {
        jQuery('.slider').slider();
    }
};

/* sortable */
Drupal.behaviors.dgd7sortable = {
    attach: function(context, settings) {
        jQuery('.sortable').sortable();
    }
};


/* behaviour */
Drupal.behaviors.dgd7tabs = {
    attach: function(context, settings){
        jQuery('.tabs').tabs();
    }
};
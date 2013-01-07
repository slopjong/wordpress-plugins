Event Registration Simple Widget
================================

Display your next event in your sidebar, created with the Event Registration plugin. After the expiration date the next event will be displayed or the widget will be completely hidden if there is no more. Additionally the class `noevent` will be assigned to it so that you can restyle it in CSS. The event category will be used as the title or 'Next event' if it has no category.

Requirements
------------

This plugin needs the [Event Registration](http://www.wpeventregister.com/) plugin to be installed and activated.

Customizable
------------

To customize your widget add new CSS rules in your theme stylesheet such as the following ones.

```
.widget_event_registration_simple_widget {

	background-image:url(http://slopjong.de/wp-content/2012/11/event.png);
	background-position: right top;
	background-repeat: no-repeat;
}

.widget_event_registration_simple_widget > .widget-title {

	width: 90%;
}
```

If you use the event badge upload it in your media manager and adapt the link.

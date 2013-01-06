# JS keyStroke

A jQuery plugin and Underscore mixin for binding actions to keyboard combinations.

## Usage

`$.keyStroke()` and `_.keyStroke()` take two required arguments (`requriedKeys` and `callback`) and a third optional (`options`) argument.

**Required**
* `requiredKeys`: Array of JavaScript keyCodes for your keystroke.  Can be an integer (rather than an array) if you only want to use one keyCode, not including modifier keys passed in the `options` argument.  Order is *not* important, and ordered keystrokes are not supported.  [This](http://www.w3.org/2002/09/tests/keys.html) page is helpful for finding keyCodes.
* `callback`: A function to call when your keystroke is executed.

**Options**
* `arguments`: An array of arguments to be passed to your callback when your keystroke is exectuted.  The last `keydown`'s `event` object is always passed as the first argument to `callback`.
* `context`: The value of `this` for your callback.
* `preventDefault`: Whether or not to `preventDefault()` on the `keydown` event that triggers your keystroke. Defaults to `true`.
* `modKeys`: Array of strings that match `keydown` event properties and can be used to include modifier keys in your keystroke.  The `modKeys` option is only used if `requiredKeys` is a single (non-array) value, otherwise it is ignored.  Examples: `'altKey'`, `'ctrlKey'`, `'metaKey'`, `'shiftKey'`

Options should be passed via an object, e.g. `{arguments: ['foo', 'bar'], context: someValueForThis, modKeys: ['altKey']}`

## Example

```javascript
saveSomething = function( event ) {
	// ...do something with the keydown event that triggered the keystroke
	someSaveAction();
}

// Save something on ctrl + s
// s = 83
$.keyStroke( 83, saveSomething, { modKeys: [ 'ctrlKey' ] } );

// Do the same thing with Underscore instead of jQuery
_.keyStroke( 83, saveSomething, { modKeys: [ 'ctrlKey' ] } );
```

You can also use anonymous callbacks.

```javascript
$.keyStroke( 83, function() { 'You pressed ALT + S!'; }, { modKeys: [ 'altKey' ] } );
```

See `/example/index.html` for an example of toggling a request cookie with a keystroke.

## Installation

Load `jquery.keystroke.js` after jQuery, or `_.keystroke.js` after Underscore.  Both plugins come with a matching `min.js` version.

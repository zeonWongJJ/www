export default {
  // Overlay built-in module's icon
  icons: {
    image: 'iui-icon iui-icon-pic',
    indent: 'iui-icon iui-icon-insert'
  },
  // Modules in use
  modules: [
    'font',
    'bold',
    'italic',
    'underline',
    'linethrough',
    'ul',
    'indent',
    'align',
    'image',
    'quote',
    'todo',
    // This is a custom module
    'customSave'
  ],
  // Overlay image module's configuration
  image: {
    maxSize: 5120 * 1024,
    imgOccupyNewRow: true,
    compress: {
      width: 1600,
      height: 1600,
      quality: 0.8
    }
  },
  // Overlay font module's configuration
  font: {
    config: {
      'xx-large': {
        fontSize: 6,
        name: 'H1'
      },
      'medium': {
        fontSize: 3,
        name: 'H2'
      },
      'small': {
        fontSize: 2,
        name: 'H3'
      },
      default: 'medium'
    },
    // Modify the font module's module inspect mechanism to inspect via style and tag name
    inspect (add) {
      add('style', {
        fontSize: ['xx-large', 'x-large', 'large', 'medium', 'small']
      }).add('tag', 'font')
    }
  },
  // Overlay ul module's configuration
  ul: {
    // When the ul module is inspected, disabled all but itself
    exclude: 'ALL_BUT_MYSELF',
    // When the ul module is clicked, execute the following method
    handler (rh) {
      console.log('i am ul!')
      rh.editor.execCommand('insertUnorderedList')
    }
  },
  // When the ul module is inspected, disabled image, todo and ul module
  quote: {
    exclude: ['image', 'todo', 'ul']
  },
  // Customize an command named getAllTexts that prints out all the text nodes under the current range object
  commands: {
    getAllTexts (rh, arg) {
      console.log(rh.getAllTextNodeInRange())
    }
  },
  shortcut: {
    // Custom a shortcut key, when you press the command + s, execute the save function
    saveNote: {
      metaKey: true,
      keyCode: 83,
      handler (editor) {
        save()
      }
    }
  },
  // Customize a module, a alert pops up when you click on the module icon
  extendModules: [{
    name: 'smile',
    icon: 'iui iui-icon-smile',
    handler (rh) {
      alert('smile~~')
    }
  }]
}

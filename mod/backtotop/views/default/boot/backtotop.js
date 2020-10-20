define(function(require) {
    const elgg = require("elgg")
    const Plugin = require("elgg/Plugin")
    const $ = require("jquery")

    const backToTopScrollFunction = () => {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          $('#backToTopButton').show()
        } else {
          $('#backToTopButton').hide()
        }
      }
      
    const backToTop = () => {
        document.body.scrollTop = 0
        document.documentElement.scrollTop = 0
      }

    return new Plugin({
        init: function () {
          elgg.register_hook_handler('ready', 'system', () => {
            window.onscroll = backToTopScrollFunction
            $('#backToTopButton').click(backToTop)
          })
        }
    })
})
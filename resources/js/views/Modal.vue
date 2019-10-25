<template id="modal-template">
  <div class="container-fluid">
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">

            <div class="modal-header">
              <div class="container-fluid">
                <slot name="header"><!--  --></slot>
              </div>
            </div>

            <div class="modal-body">
              <slot name="body"><!--  --></slot>
            </div>

            <div class="modal-footer">
              <div class="container-fluid">
                <div class="row">
                  <slot name="footer-left">
                    <div class="col text-center">
                      <button class="btn btn-sm btn-danger" @click="$emit('close')">
                        CERRAR
                      </button>
                    </div>
                  </slot>

                  <slot name="footer-right">
                    
                  </slot>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </transition>
  </div>  
</template>

<style type="text/css">
  .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
  }

  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }

  .modal-container {
    width: 75%;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
  }

  .modal-body {
    margin: 20px 0;
  }

  /*
   * The following styles are auto-applied to elements with
   * transition="modal" when their visibility is toggled
   * by Vue.js.
   *
   * You can easily play with the modal transition by editing
   * these styles.
   */

  .modal-enter {
    opacity: 0;
  }

  .modal-leave-active {
    opacity: 0;
  }

  .modal-enter .modal-container,
  .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }
</style>
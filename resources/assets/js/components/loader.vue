
<template>
  <div>
    <div class="preloader-wrapper small active">
      <div class="spinner-layer spinner-red-only">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
      </div>
    </div>

  </div>
</template>

<style lang="scss" scoped>
  @import "../../sass/variables";
  // https://github.com/Dogfalo/materialize/blob/v1-dev/sass/components/_preloader.scss

  .preloader-wrapper {
    display: inline-block;
    position: relative;
    width: 50px;
    height: 50px;

    &.small {
      width: 36px;
      height: 36px;
    }

    &.big {
      width: 64px;
      height: 64px;
    }

    &.active {
      /* duration: 360 * ARCTIME / (ARCSTARTROT + (360-ARCSIZE)) */
      -webkit-animation: container-rotate 1568ms linear infinite;
      animation: container-rotate 1568ms linear infinite;
    }
  }

  @-webkit-keyframes container-rotate {
    to { -webkit-transform: rotate(360deg) }
  }

  @keyframes container-rotate {
    to { transform: rotate(360deg) }
  }

  .spinner-layer {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    //border-color: $spinner-default-color;
  }


  .spinner-red,
  .spinner-red-only {
    border-color: $brand-primary;
  }

  .active .spinner-layer.spinner-red {
    /* durations: 4 * ARCTIME */
    -webkit-animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both, red-fade-in-out 5332ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
    animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both, red-fade-in-out 5332ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
  }
  .active .spinner-layer {
    /* durations: 4 * ARCTIME */
    opacity: 1;
    -webkit-animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
    animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
  }

  @-webkit-keyframes fill-unfill-rotate {
    12.5% { -webkit-transform: rotate(135deg);  } /* 0.5 * ARCSIZE */
    25%   { -webkit-transform: rotate(270deg);  } /* 1   * ARCSIZE */
    37.5% { -webkit-transform: rotate(405deg);  } /* 1.5 * ARCSIZE */
    50%   { -webkit-transform: rotate(540deg);  } /* 2   * ARCSIZE */
    62.5% { -webkit-transform: rotate(675deg);  } /* 2.5 * ARCSIZE */
    75%   { -webkit-transform: rotate(810deg);  } /* 3   * ARCSIZE */
    87.5% { -webkit-transform: rotate(945deg);  } /* 3.5 * ARCSIZE */
    to    { -webkit-transform: rotate(1080deg); } /* 4   * ARCSIZE */
  }

  @keyframes fill-unfill-rotate {
    12.5% { transform: rotate(135deg);  } /* 0.5 * ARCSIZE */
    25%   { transform: rotate(270deg);  } /* 1   * ARCSIZE */
    37.5% { transform: rotate(405deg);  } /* 1.5 * ARCSIZE */
    50%   { transform: rotate(540deg);  } /* 2   * ARCSIZE */
    62.5% { transform: rotate(675deg);  } /* 2.5 * ARCSIZE */
    75%   { transform: rotate(810deg);  } /* 3   * ARCSIZE */
    87.5% { transform: rotate(945deg);  } /* 3.5 * ARCSIZE */
    to    { transform: rotate(1080deg); } /* 4   * ARCSIZE */
  }

  @-webkit-keyframes red-fade-in-out {
    from { opacity: 0; }
    15% { opacity: 0; }
    25% { opacity: 1; }
    50% { opacity: 1; }
    51% { opacity: 0; }
  }

  @keyframes red-fade-in-out {
    from { opacity: 0; }
    15% { opacity: 0; }
    25% { opacity: 1; }
    50% { opacity: 1; }
    51% { opacity: 0; }
  }
  /**
   * Patch the gap that appear between the two adjacent div.circle-clipper while the
   * spinner is rotating (appears on Chrome 38, Safari 7.1, and IE 11).
   */
  .gap-patch {
    position: absolute;
    top: 0;
    left: 45%;
    width: 10%;
    height: 100%;
    overflow: hidden;
    border-color: inherit;
  }

  .gap-patch .circle {
    width: 1000%;
    left: -450%;
  }

  .circle-clipper {
    display: inline-block;
    position: relative;
    width: 50%;
    height: 100%;
    overflow: hidden;
    border-color: inherit;

    .circle {
      width: 200%;
      height: 100%;
      border-width: 3px; /* STROKEWIDTH */
      border-style: solid;
      border-color: inherit;
      border-bottom-color: transparent !important;
      border-radius: 50%;
      -webkit-animation: none;
      animation: none;
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
    }

    &.left .circle {
      left: 0;
      border-right-color: transparent !important;
      -webkit-transform: rotate(129deg);
      transform: rotate(129deg);
    }
    &.right .circle {
      left: -100%;
      border-left-color: transparent !important;
      -webkit-transform: rotate(-129deg);
      transform: rotate(-129deg);
    }
  }



  .active .circle-clipper.left .circle {
    /* duration: ARCTIME */
    -webkit-animation: left-spin 1333ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
    animation: left-spin 1333ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
  }

  .active .circle-clipper.right .circle {
    /* duration: ARCTIME */
    -webkit-animation: right-spin 1333ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
    animation: right-spin 1333ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
  }

  @-webkit-keyframes left-spin {
    from { -webkit-transform: rotate(130deg); }
    50% { -webkit-transform: rotate(-5deg); }
    to { -webkit-transform: rotate(130deg); }
  }

  @keyframes left-spin {
    from { transform: rotate(130deg); }
    50% { transform: rotate(-5deg); }
    to { transform: rotate(130deg); }
  }

  @-webkit-keyframes right-spin {
    from { -webkit-transform: rotate(-130deg); }
    50% { -webkit-transform: rotate(5deg); }
    to { -webkit-transform: rotate(-130deg); }
  }

  @keyframes right-spin {
    from { transform: rotate(-130deg); }
    50% { transform: rotate(5deg); }
    to { transform: rotate(-130deg); }
  }

  #spinnerContainer.cooldown {
    /* duration: SHRINK_TIME */
    -webkit-animation: container-rotate 1568ms linear infinite, fade-out 400ms cubic-bezier(0.4, 0.0, 0.2, 1);
    animation: container-rotate 1568ms linear infinite, fade-out 400ms cubic-bezier(0.4, 0.0, 0.2, 1);
  }

  @-webkit-keyframes fade-out {
    from { opacity: 1; }
    to { opacity: 0; }
  }

  @keyframes fade-out {
    from { opacity: 1; }
    to { opacity: 0; }
  }

</style>
<template>
  <div
    class="h-full w-full"
    ref="graph"
  ></div>
</template>

<script>
import ProgressBar from 'progressbar.js'

export default {
  props: ['progress', 'text'],
  data() {
    return {
      bar: null,
    }
  },
  methods: {
    initBar() {
      this.bar = new ProgressBar.Circle(this.$refs.graph, {
        color: 'none',
        trailColor: '#a3e63570',
        trailWidth: 2,
        duration: 599,
        easing: 'easeOut',
        strokeWidth: 10,
        text: {
          className: this.textClasses,
        },
      })
    },
    runBar(val) {
      let to = { color: '#a3e635', a: 1 }
      if (val > 1) {
        to = { color: '#ef4444', a: 1 }
        val = 1
      }
      this.bar.animate(val, {
        from: { color: '#a3e635', a: 0 },
        to,
        step: function (state, circle) {
          circle.path.setAttribute('stroke', state.color)
        },
      })
      this.bar.setText(`${this.text}`)
    },
  },
  computed: {
    textClasses() {
      return [
        this.progress > 1 ? 'text-red-600' : 'text-lime-600',
        'font-num font-bold text-2xl lg:text-4xl',
      ].join(' ')
    },
  },
  watch: {
    progress(val) {
      this.runBar(val)
    },
  },
  mounted() {
    this.initBar()
  },
}
</script>

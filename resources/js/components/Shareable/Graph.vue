<template>
  <div
    class="w-full h-full"
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
        trailColor: '#CFFAFE',
        trailWidth: 3,
        duration: 599,
        easing: 'easeOut',
        strokeWidth: 20,
        text: {
          className: this.textClasses,
        },
      })
    },
    runBar(val) {
      let to = { color: '#06B6D4', a: 1 }
      if (val > 1) {
        to = { color: '#EF4444', a: 1 }
        val = 1
      }
      this.bar.animate(val, {
        from: { color: '#67E8F9', a: 0 },
        to,
        step: function (state, circle) {
          circle.path.setAttribute('stroke', state.color)
        },
      })
      this.bar.setText(`${this.text} cal.`)
    },
  },
  computed: {
    textClasses() {
      return [
        this.progress > 1 ? 'text-red-600' : 'text-sky-600',
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

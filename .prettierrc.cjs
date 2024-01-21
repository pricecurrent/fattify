module.exports = {
  semi: false,
  singleQuote: true,
  tabWidth: 2,
  trailingComma: 'all',
  printWidth: 180,
  arrowParens: 'avoid',
  plugins: [require('@shufo/prettier-plugin-blade')],
  overrides: [
    {
      files: ['*.blade.php'],
      options: {
        parser: 'blade',
        wrapAttributes: 'force-expand-multiline',
        tabWidth: 2,
        printWidth: 300,
        sortTailwindcssClasses: true,
      },
    },
  ],
}

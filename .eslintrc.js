module.exports = {
    root: true,
    env: {
        node: true,
        browser: true
    },
    extends: [
        'plugin:vue/recommended',
        'eslint:recommended',
        'plugin:prettier/recommended'
    ],
    plugins: ['unused-imports'],
    parserOptions: {
        parser: '@babel/eslint-parser',
        requireConfigFile: false
    },
    rules: {
        'prettier/prettier': 'error',
        'vue/component-name-in-template-casing': ['error', 'PascalCase'],
        'unused-imports/no-unused-imports': 'error',
        'vue/no-v-html': 'off',
        'vue/no-multiple-template-root': 'off',
        'vue/no-mutating-props': 'off',
        'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off'
    }
}

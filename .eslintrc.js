module.exports = {
    root: true,
    env: {
        node: true,
        browser: true,
    },
    extends: [
        'plugin:vue/recommended',
        'eslint:recommended',
        'plugin:prettier/recommended'
    ],
    parserOptions: {
        parser: '@babel/eslint-parser',
        requireConfigFile: false,
    },
    rules: {
        'prettier/prettier': 'error',
        'vue/component-name-in-template-casing': ['error', 'PascalCase'],
        'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off'
    }
}
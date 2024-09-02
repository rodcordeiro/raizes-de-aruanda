import globals from 'globals';
import pluginJs from '@eslint/js';
import tseslint from 'typescript-eslint';
import pluginReactConfig from 'eslint-plugin-react/configs/recommended.js';
import { fixupConfigRules } from '@eslint/compat';

export default [
	{ languageOptions: { globals: globals.browser } },
	pluginJs.configs.recommended,
	...tseslint.configs.recommended,
	...fixupConfigRules(pluginReactConfig),
	{
		files: ['**/*.ts', '**/*.tsx', '**/**/*.ts', '**/**/*.tsx'],
		rules: {
			'no-unused-vars': [
				'error',
				{
					argsIgnorePattern: '^_',
					ignoreRestSiblings: true,
					destructuredArrayIgnorePattern: '^_',
				},
			],
			'react/react-in-jsx-scope': 'off',
		},
	},
];

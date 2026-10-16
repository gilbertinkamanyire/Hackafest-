<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gemma AI Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for integrating the Gemma large language model API
    | into eWitnessVault for AI-powered evidence analysis and case summarization.
    |
    */

    'api_key' => env('GEMMA_API_KEY'),

    'endpoint' => env('GEMMA_API_ENDPOINT', 'https://generativelanguage.googleapis.com/v1beta/models/gemma-3-1b-it:generateContent'),

    'model' => env('GEMMA_MODEL', 'gemma-3-1b-it'),

    'timeout' => env('GEMMA_TIMEOUT', 60),

    'max_tokens' => env('GEMMA_MAX_TOKENS', 1024),

    'temperature' => env('GEMMA_TEMPERATURE', 0.3),

    /*
    |--------------------------------------------------------------------------
    | AI Feature Flags
    |--------------------------------------------------------------------------
    |
    | Enable/disable specific AI features in the application.
    |
    */

    'features' => [
        'evidence_analysis' => env('GEMMA_FEATURE_EVIDENCE_ANALYSIS', true),
        'case_summarization' => env('GEMMA_FEATURE_CASE_SUMMARIZATION', true),
    ],

];

# Bank Logo Fetcher

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ravansagar/bank-logo-fetcher.svg?style=flat-square)](https://packagist.org/packages/ravansagar/bank-logo-fetcher)
[![Total Downloads](https://img.shields.io/packagist/dt/ravansagar/bank-logo-fetcher.svg?style=flat-square)](https://packagist.org/packages/ravansagar/bank-logo-fetcher)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

A lightweight, zero-dependency PHP utility package to easily resolve Nepali commercial bank names, retrieve their official website URLs, and fetch high-resolution brand logos via Google S2 Favicon API.

It features robust normalizers, strict acronym aliases (e.g., `NIMB`, `NIC Asia`, `NMB`), and a smart string-distance fallback (`levenshtein`) to seamlessly resolve user typos and variations.

---

## Features

- **Accurate Resolution:** Handles exact names, common text variations, and punctuation removals.
- **Acronym Aliases:** Maps short handles directly to formal entities (e.g., `rbb` -> `Rastriya Banijya Bank Ltd.`).
- **Fuzzy Matching:** Automatically repairs dynamic typographical mistakes using string distance thresholds.
- **High-Res Logos:** Generates clean image stream URIs mapped directly to `128x128px` source domains.

## Installation

You can install the package via Composer:

```bash
composer require ravansagar/bank-logo-fetcher
```

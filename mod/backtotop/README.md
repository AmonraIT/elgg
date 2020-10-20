# Elgg Back to top 

## Introduction

This plugin for [Elgg](https://elgg.org/) adds a hovering button to the lower right of the page, which scrolls back to the top of page when clicked.

## Usage

Unzip the plugin into the directory `mod/backtotop` in your Elgg installation. After activating the plugin using the plugin administration, reset the caches.

## Styling

The button the plugin adds has the id `backToTopButton`, which you can style using css by extending or completely overwriting the `css/backtotop.css` view.

# Development

## Release

Run the following command to release a new version to GitHub

    GITHUB_TOKEN=<my token> grunt release:<new release number>
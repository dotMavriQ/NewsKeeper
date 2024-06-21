# NewsKeeper

NewsKeeper is a versatile WordPress plugin designed to enhance content visibility and accessibility across WordPress sites. It allows users to dynamically display recent posts through a widget, with options to filter posts by categories or tags. Developed as part of a case study for potential recruitment, NewsKeeper integrates seamlessly with WordPress environments and is compatible with PolyLang for multilingual sites.

## Features

- **Shortcode Integration**: Easily integrate NewsKeeper into any page or post with the `[NewsKeeper]` shortcode.
- **Dynamic Filtering**: Users can filter visible posts by `Categories` or `Tags` to find content tailored to their interests.
- **PolyLang Compatibility**: Automatically adjusts displayed posts to match the currently selected language in PolyLang, enhancing the user experience for multilingual sites.
- **Extensible Codebase**: Developers can utilize hooks and filters provided by NewsKeeper to extend its functionality and tailor it to specific needs.

## Installation

1. **Download the Plugin**:
   Download the latest version of NewsKeeper from the WordPress plugin repository or the release section of this GitHub repository.

2. **Upload to WordPress**:
   Navigate to your WordPress dashboard, go to the `Plugins` section, and choose `Add New`. Upload the downloaded plugin file and install it.

3. **Activate NewsKeeper**:
   After installation, activate the plugin through the 'Plugins' menu in WordPress.

## Usage

To use NewsKeeper on your WordPress site:
- Navigate to the page or post where you wish to display the plugin.
- Insert the `[NewsKeeper]` shortcode where you want the recent posts to appear.
- Optionally, use the plugin's widget settings to customize which categories or tags will be displayed by default.

## Configuration

**Shortcode Parameters**:
- `categories`: Specify categories to filter the posts.
- `tags`: Specify tags to filter the posts.

Example usage of the shortcode with parameters:
```plaintext
[NewsKeeper categories="news, updates" tags="wordpress"]
```

## Roadmap

- **AJAX Support**: Enhance interactivity by allowing users to dynamically add filters for categories and tags without reloading the page.
- **Search Functionality**: Implement a search box within the plugin to allow users to search for specific posts.
- **Styling Improvements**: Upgrade the default styling to improve visual presentation and user experience.

## Contributing

Contributions to NewsKeeper are welcome! Whether it's bug fixes, feature additions, or improvements to the documentation, we appreciate your help. Please submit a pull request or open an issue to discuss your ideas.

## License

NewsKeeper is released under the GPL-3.0 license. See the LICENSE file for more details.

---

For more information and support, please contact the creator at [support@email.com](social@dotmavriq.life) or, preferably, by making an issue on GitHub.


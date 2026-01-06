#!/usr/bin/env python3
"""
Script to add accessibility metadata to SVG ERD diagrams.
Adds title, description, and ARIA attributes for better accessibility.
"""

import sys
import re
import html
from pathlib import Path


def escape_xml(text):
    """Escape XML special characters."""
    return html.escape(text, quote=True)


def add_svg_description(svg_path, title, description):
    """
    Add or update title and description elements in an SVG file for accessibility.
    
    Args:
        svg_path: Path to the SVG file
        title: Title for the SVG
        description: Detailed description of the SVG content
    """
    svg_file = Path(svg_path)
    
    if not svg_file.exists():
        print(f"Error: File {svg_path} does not exist")
        return False
    
    # Check if file is empty
    if svg_file.stat().st_size == 0:
        print(f"Warning: File {svg_path} is empty, skipping")
        return False
    
    # Read the SVG content
    with open(svg_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Check if it's a valid SVG
    if '<svg' not in content:
        print(f"Error: {svg_path} does not appear to be a valid SVG file")
        return False
    
    # Escape XML special characters in title and description
    safe_title = escape_xml(title)
    safe_description = escape_xml(description)
    
    # Create the title and description elements with IDs
    title_element_with_id = f'<title id="svg-title">{safe_title}</title>'
    desc_element_with_id = f'<desc id="svg-desc">{safe_description}</desc>'
    
    # Find the opening svg tag
    svg_match = re.search(r'<svg([^>]*)>', content)
    if not svg_match:
        print(f"Error: Could not find SVG opening tag in {svg_path}")
        return False
    
    svg_tag = svg_match.group(0)
    svg_attrs = svg_match.group(1)
    svg_tag_start = svg_match.start()
    svg_tag_end = svg_match.end()
    
    # Add role and aria-labelledby attributes if not present
    new_svg_attrs = svg_attrs
    if 'role=' not in new_svg_attrs:
        new_svg_attrs = ' role="img"' + new_svg_attrs
    if 'aria-labelledby=' not in new_svg_attrs:
        new_svg_attrs = ' aria-labelledby="svg-title svg-desc"' + new_svg_attrs
    
    new_svg_tag = f'<svg{new_svg_attrs}>'
    
    # Find the first <g> tag after svg
    g_match = re.search(r'<g[^>]*>', content[svg_tag_end:])
    if g_match:
        g_start = svg_tag_end + g_match.start()
        
        # Look for existing title and desc within the SVG (not inside nested elements)
        # Remove old title and desc if they exist right after svg tag
        after_svg = content[svg_tag_end:g_start]
        # Use more specific regex to handle nested elements correctly
        after_svg = re.sub(r'\s*<title[^>]*>.*?</title>\s*', '', after_svg, flags=re.DOTALL)
        after_svg = re.sub(r'\s*<desc[^>]*>.*?</desc>\s*', '', after_svg, flags=re.DOTALL)
        
        # Construct new content with title and desc right after svg tag
        new_content = (
            content[:svg_tag_start] +
            new_svg_tag +
            '\n' + title_element_with_id + '\n' + desc_element_with_id + '\n' +
            after_svg +
            content[g_start:]
        )
    else:
        # No <g> tag found, just add after svg tag
        new_content = (
            content[:svg_tag_start] +
            new_svg_tag +
            '\n' + title_element_with_id + '\n' + desc_element_with_id + '\n' +
            content[svg_tag_end:]
        )
    
    # Write back to file
    with open(svg_file, 'w', encoding='utf-8') as f:
        f.write(new_content)
    
    print(f"Successfully added description to {svg_path}")
    return True


def main():
    """Main function to add descriptions to ERD SVG files."""
    
    # Descriptions for the ERD diagrams
    erd_title = "Fleetbase Database Schema - Entity Relationship Diagram"
    erd_description = (
        "Entity Relationship Diagram (ERD) showing the complete database schema for Fleetbase, "
        "a modular logistics and supply chain operating system. The diagram illustrates tables, "
        "columns, data types, primary keys (PK), foreign keys (FK), and relationships between "
        "entities including companies, users, drivers, vehicles, orders, payloads, tracking, "
        "and storefront components. The schema supports both the core Fleetbase system and "
        "the FixFlo extension for fixture management in the maritime shipping industry."
    )
    
    erd_dark_title = "Fleetbase Database Schema - Entity Relationship Diagram (Dark Theme)"
    erd_dark_description = (
        "Entity Relationship Diagram (ERD) showing the complete database schema for Fleetbase "
        "in dark theme. This diagram illustrates the same database structure as the light theme "
        "version, displaying tables, columns, data types, primary keys (PK), foreign keys (FK), "
        "and relationships between entities. The dark theme is optimized for viewing in dark mode "
        "environments and includes the core Fleetbase system and FixFlo extension schemas."
    )
    
    # Process both ERD files
    script_dir = Path(__file__).parent
    erd_svg = script_dir / 'erd.svg'
    erd_dark_svg = script_dir / 'erd-dark.svg'
    
    success = True
    
    if erd_svg.exists():
        if not add_svg_description(erd_svg, erd_title, erd_description):
            success = False
    else:
        print(f"Warning: {erd_svg} not found")
    
    if erd_dark_svg.exists() and erd_dark_svg.stat().st_size > 0:
        if not add_svg_description(erd_dark_svg, erd_dark_title, erd_dark_description):
            success = False
    else:
        print(f"Info: {erd_dark_svg} not found or empty, skipping")
    
    return 0 if success else 1


if __name__ == '__main__':
    sys.exit(main())

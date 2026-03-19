---
name: create-post
description: Create a fully researched, written, and published WordPress blog post with a featured image.
user_invocable: true
---

# Create Blog Post

You are orchestrating a blog post pipeline. Follow these steps in order, waiting for user input where indicated.

---

## Step 1 — Topic Intake

Ask the user for:
- **Post idea / topic** — what the post is about
- **Target audience** — who is this for?
- **Tone** — professional, casual, conversational, authoritative, etc.
- **Keywords** — any SEO keywords to target (optional)
- **Category** — blog category if they have a preference (optional)
- **Author** — author display name (optional, defaults to existing user)

If the user provided some of this with the `/create-post` command, acknowledge what you have and only ask for what's missing. At minimum you need the topic.

---

## Step 2 — Research

Spawn the `research-topic` agent with the topic, audience, and tone context:

```
Use the Agent tool with the research-topic agent. Pass the topic, target audience, and tone as context.
```

While the agent works, tell the user: "Researching your topic now..."

---

## Step 3 — Present Research + Outline

When research returns, present:
1. A summary of key findings (3–5 bullets)
2. The 3 suggested titles — ask the user to pick one or provide their own
3. The proposed outline (H2 sections)

**Wait for user approval.** They may want to:
- Pick a different title
- Adjust the outline (add/remove/reorder sections)
- Shift the angle or emphasis

Do not proceed until the user confirms the title and outline.

---

## Step 4 — Write the Post

Write the full blog post using **Gutenberg block markup**. Every element must be wrapped in WordPress block comments so the post is fully editable in the block editor.

### Block Format Reference

**Paragraph:**
```html
<!-- wp:paragraph -->
<p>Your paragraph text here.</p>
<!-- /wp:paragraph -->
```

**Heading (H2):**
```html
<!-- wp:heading -->
<h2 class="wp-block-heading">Section Title</h2>
<!-- /wp:heading -->
```

**Heading (H3):**
```html
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Subsection Title</h3>
<!-- /wp:heading -->
```

**Unordered List:**
```html
<!-- wp:list -->
<ul class="wp-block-list">
<li>First item</li>
<li>Second item</li>
</ul>
<!-- /wp:list -->
```

**Ordered List:**
```html
<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list">
<li>First item</li>
<li>Second item</li>
</ol>
<!-- /wp:list -->
```

**Quote:**
```html
<!-- wp:quote -->
<blockquote class="wp-block-quote">
<p>Quote text here.</p><cite>Attribution</cite>
</blockquote>
<!-- /wp:quote -->
```

**Separator:**
```html
<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->
```

### Writing Guidelines

- Write in the tone agreed upon in Step 1
- Use the research from Step 2 — cite statistics and reference sources naturally
- Target 1000–1800 words depending on topic complexity
- Use H2 for main sections, H3 for subsections
- Include a compelling introduction and a clear conclusion or call-to-action
- Break up long paragraphs — aim for 2–4 sentences per paragraph
- Use lists where they improve readability
- Write for the target audience identified in Step 1
- Weave in SEO keywords naturally (don't stuff)

Also generate a **subtitle** (1 sentence, ~10–15 words) that complements the title.

Store the complete post content, title, and subtitle — you'll need them in Step 8.

---

## Step 5 — Present Draft

Show the user the full post in a readable format (render the HTML as markdown for readability, but keep the Gutenberg markup stored for publishing).

Show:
- **Title**
- **Subtitle**
- **Full post content**
- **Word count**

Ask: "How does this look? I can adjust tone, length, sections, or any specific parts. Say **'good to go'** when you're happy with it."

Iterate on edits until the user approves.

---

## Step 6 — Image Prompt

Generate a detailed image generation prompt for the post's featured image. The prompt should:

- Describe a **16:9 landscape** composition (1200x675)
- Match the editorial style and subject matter of the post
- Specify an art style (e.g., editorial photography, flat illustration, isometric, watercolor, etc.)
- Include color palette guidance that would complement the blog's design
- Be specific enough to get a good result on the first try
- Avoid text in the image (text in AI images is unreliable)

Present the prompt to the user and say:

> **Here's your image prompt.** Copy and paste it into Gemini at [gemini.google.com/app](https://gemini.google.com/app), generate the image, and download it. Let me know when it's in your Downloads folder.

**Wait for the user to confirm** they've downloaded the image.

---

## Step 7 — Process Image

When the user confirms the image is downloaded:

### 7a. Find the image
```bash
ls -t ~/Downloads/*.{png,jpg,jpeg,webp} 2>/dev/null | head -5
```

Show the user the filename and ask them to confirm it's the right one.

### 7b. Generate a human-readable filename
Create a slug from the post title for the image filename. Example:
- Title: "I Built a WordPress Theme Where the Build Step Is a Conversation"
- Filename: `ai-first-wordpress-theme-development.jpg`

### 7c. Remove Gemini watermark
Gemini images have a small 4-pointed star watermark in the bottom-right corner. Remove it by painting over it with a color sampled from the surrounding area:

```bash
# Check ImageMagick is available (install if needed: brew install imagemagick)
which magick || brew install imagemagick

# Get image dimensions
magick identify "<source_file>"

# Sample the background color near the watermark (adjust coords for image size)
# For a WxH image, sample at approximately (W-200, H-50)
magick "<source_file>" -format "%[pixel:u.p{<x>,<y>}]" info:

# Paint over the watermark region and resize to 1200x675
# The watermark is typically in the last ~10% of width and height from the bottom-right corner
magick "<source_file>" \
  -fill "<sampled_color>" \
  -draw "rectangle <x1>,<y1> <W>,<H>" \
  -resize 1200x675! \
  /tmp/<slug>.jpg
```

### 7d. Verify the result
Read the processed image to confirm the watermark is gone and the image looks good. If still visible, expand the paint region and retry.

---

## Step 8 — Upload and Create Post

This step creates the post on WordPress.

### SSH Details

The `kansowp` alias wraps SSH + WP-CLI. **For commands with simple arguments** (no spaces, no HTML), use `kansowp` directly. **For commands with complex arguments** (titles with spaces, HTML content, subtitles), use raw SSH to avoid shell quoting issues.

Extract SSH details once:
```bash
zsh -i -c "alias kansowp" 2>&1
```
Parse to get PORT, USER, HOST, and the WP-CLI path (typically `~/bin/wp`). The alias format is:
`kansowp='ssh -p PORT USER@HOST '\''cd ~/domains/DOMAIN/public_html && ~/bin/wp'\'''`

For the examples below, the raw SSH pattern is:
```bash
ssh -p <port> <user>@<host> '<wp-cli-command>'
```
where `<wp-cli-command>` is: `cd ~/domains/<domain>/public_html && ~/bin/wp <args>`

### 8a. Upload image to server
```bash
scp -P <port> /tmp/<slug>.jpg <user>@<host>:/tmp/
```

### 8b. Import image and set title via raw SSH
**Always use raw SSH for media import** — the `--title` argument with spaces breaks through the alias.
```bash
ssh -p <port> <user>@<host> "cd ~/domains/<domain>/public_html && ~/bin/wp media import /tmp/<slug>.jpg --title='<Human Readable Title>' --porcelain"
```
This returns the attachment ID. Capture it.

### 8c. Write post content to temp file and upload
Write the Gutenberg HTML content to `/tmp/post-content.html` using the Write tool, then SCP it:
```bash
scp -P <port> /tmp/post-content.html <user>@<host>:/tmp/
```

### 8d. Create draft post (two-step process)
**Step 1 — Create empty draft via raw SSH** (title contains spaces):
```bash
ssh -p <port> <user>@<host> "cd ~/domains/<domain>/public_html && ~/bin/wp post create --post_status=draft --post_title='<title>' --porcelain"
```
This returns the post ID.

**Step 2 — Update with content via raw SSH** (content contains HTML):
```bash
ssh -p <port> <user>@<host> 'cd ~/domains/<domain>/public_html && ~/bin/wp post update <post_id> --post_content="$(cat /tmp/post-content.html)"'
```

### 8e. Set featured image
Simple numeric args — `kansowp` alias is fine:
```bash
zsh -i -c "kansowp post meta set <post_id> _thumbnail_id <attachment_id>" 2>&1
```

### 8f. Set subtitle via raw SSH
Subtitle contains spaces — use raw SSH:
```bash
ssh -p <port> <user>@<host> "cd ~/domains/<domain>/public_html && ~/bin/wp post meta set <post_id> _post_subtitle '<subtitle>'"
```

### 8g. Set category
Single-word slug — `kansowp` alias is fine:
```bash
zsh -i -c "kansowp post term set <post_id> category <category-slug>" 2>&1
```

### 8h. Set author (if specified)
If the user requested a specific author, update the WordPress user's display name:
```bash
ssh -p <port> <user>@<host> "cd ~/domains/<domain>/public_html && ~/bin/wp user update 1 --display_name='<Author Name>'"
```
Note: This updates the display name site-wide for user ID 1 (the primary admin account).

### 8i. Clean up temp files
```bash
rm /tmp/<slug>.jpg /tmp/post-content.html
ssh -p <port> <user>@<host> "rm -f /tmp/<slug>.jpg /tmp/post-content.html"
```

### 8j. Get the draft URL
```bash
zsh -i -c "kansowp post get <post_id> --field=url" 2>&1
```

Present the draft URL to the user:
> **Draft created!** Preview it here: [URL]
>
> When you're happy with it, say **'publish'** and I'll make it live.

---

## Step 9 — Publish

When the user confirms:

```bash
zsh -i -c "kansowp post update <post_id> --post_status=publish" 2>&1
```

Get the live URL:
```bash
zsh -i -c "kansowp post get <post_id> --field=url" 2>&1
```

Tell the user:
> **Published!** Your post is live at: [URL]

---

## Error Handling

- If any WP-CLI command fails, show the error and suggest next steps
- If SCP fails, check if the SSH alias is accessible: `zsh -i -c "kansowp option get siteurl" 2>&1`
- If image resize fails, check if the file exists and try with the original format
- If a command fails due to quoting, switch from the `kansowp` alias to raw SSH
- Always clean up temp files, even on failure

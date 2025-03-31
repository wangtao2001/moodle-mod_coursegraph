# Requirements

- Node.js 18.20.8+
- Tested with Moodle 4.5.1+

# Installation

1. Clone the repository to the directory `moodle/mod` and rename it to `coursegraph`

```bash
git clone git@github.com:wangtao2001/moodle-mod_coursegraph.git
mv moodle-mod_coursegraph coursegraph
cd coursegraph
```

2. Install dependencies

```bash
cd vue
npm install
```

3. Build the plugin

```bash
npm run build
```

4. Install the plugin in Moodle

Login to the web interface as an administrator and follow the prompts to upgrade the database as appropriate.








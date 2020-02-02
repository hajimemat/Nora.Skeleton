# Configuration file for the Sphinx documentation builder.
#
# This file only contains a selection of the most common options. For a full
# list see the documentation:
# https://www.sphinx-doc.org/en/master/usage/configuration.html

# -- Path setup --------------------------------------------------------------

# If extensions (or modules to document with autodoc) are in another directory,
# add these directories to sys.path here. If the directory is relative to the
# documentation root, use os.path.abspath to make it absolute, like shown here.
#
import os
import sys
sys.path.insert(0, os.path.abspath('.'))


# -- Project information -----------------------------------------------------

project = '__Project__'
copyright = '2019, __Vendor__'
author = '__name__'

# The full version, including alpha/beta/rc tags
release = '1.0'


# -- General configuration ---------------------------------------------------

# 日本語索引
# See https://h12u.com/sphinx/yogosyu/README_ja.html
import distutils.sysconfig
site_package_path = distutils.sysconfig.get_python_lib()
sys.path.insert(0, os.path.join(site_package_path, 'sortorder'))
sys.path.insert(0, os.path.join(site_package_path, 'sphinxcontrib/gosyu'))

# Add any Sphinx extension module names here, as strings. They can be
# extensions coming with Sphinx (named 'sphinx.ext.*') or your custom
# ones.
extensions = [
    'sphinx.ext.graphviz',
    'sphinxcontrib.plantuml',
    'sphinxcontrib.blockdiag',
    'sphinxcontrib.seqdiag',
    'sphinxcontrib.nwdiag',
    'sphinxcontrib.actdiag',
    'sphinxcontrib.httpdomain',
    'sphinxcontrib.phpdomain',
    'sphinx_rtd_theme',
    'sphinx.ext.todo',
    'sphinx.ext.imgconverter'
]

# TODOを設定
todo_include_todos=True

# 図面設定
#plantjar = os.getenv('PLANTUML')
plantjar = '/usr/share/java/plantuml/plantuml.jar'
#plantuml = 'java -jar %s -config ../plantuml.config.pu' % plantjar
plantuml = 'java -jar %s -config ./plantuml-config.pu' % plantjar

# Add any paths that contain templates here, relative to this directory.
templates_path = ['_templates']

# List of patterns, relative to source directory, that match files and
# directories to ignore when looking for source files.
# This pattern also affects html_static_path and html_extra_path.
exclude_patterns = ['_build', 'Thumbs.db', '.DS_Store', '.git']


# -- Options for HTML output -------------------------------------------------

# The theme to use for HTML and HTML Help pages.  See the documentation for
# a list of builtin themes.
#
# html_theme = 'press'
#
# html_logo = '_static/avap-logo.png'
# html_css_files = ['css/custom.css']
# html_sidebars = {'**': ['util/searchbox.html', 'util/sidetoc.html']}
# html_theme_options = {
#     "external_links": [
#         ("Avap", "https://avap.co.jp"),
#         ("Theme", "https://schettino72.github.io/sphinx_press_site/")
#     ]
# }
#
# html_theme = 't3SphinxThemeRtd'
# import t3SphinxThemeRtd
# html_theme_path = [t3SphinxThemeRtd.get_html_theme_path()]
#
html_theme = 'sphinx_rtd_theme'
html_style = 'css/custom_rtd.css'
# import t3SphinxThemeRtd
# html_theme_path = [t3SphinxThemeRtd.get_html_theme_path()]

# Add any paths that contain custom static files (such as style sheets) here,
# relative to this directory. They are copied after the builtin static files,
# so a file named "default.css" will overwrite the builtin "default.css".
html_static_path = ['_static']


# PHP設定
from sphinx.highlighting import lexers
from pygments.lexers.web import PhpLexer
lexers['php'] = PhpLexer(startinline=True, linenos=1)
lexers['php-annotations'] = PhpLexer(startinline=True, linenos=1)
primary_domain = 'php'


# Latex設定
# PLANTUML環境変数を定義してから実行する
# export PLANTUML="/usr/share/java/plantuml/plantuml.jar -config /home/kurari/nora/TWB.Sen/config.pu"
# sphinx-build -b ./doc /tmp/pdf
# cd /tmp/pdf 
# make
language = 'ja'
latex_docclass = {'manual': 'jsbook'}


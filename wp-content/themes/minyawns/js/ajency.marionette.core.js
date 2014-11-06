(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var $, Backbone, Marionette, Mustache, _;

$ = require("jquery");

require("backbone").$ = $ || jQuery;

Backbone = require("backbone");

Mustache = require("mustache");

Marionette = require("backbone.marionette");

_ = require('underscore');

_.templateSettings = {
  evaluate: /\{\[([\s\S]+?)\]\}/g,
  interpolate: /\{\{([\s\S]+?)\}\}/g
};

Marionette._ctrl = {};

Marionette.run = function(options) {
  var CtrlClass;
  CtrlClass = Marionette._ctrl[options['ctrl']];
  return new CtrlClass({
    region: options['region'],
    options: options['args']
  });
};

Marionette.Renderer.render = function(template, data) {
  if (!template) {
    template = '';
  }
  if (typeof template === "function") {
    template = template();
  }
  return Mustache.to_html(template, data);
};



},{"backbone":"backbone","backbone.marionette":"backbone.marionette","jquery":"jquery","underscore":"underscore","mustache":"mustache"}]},{},[1]);

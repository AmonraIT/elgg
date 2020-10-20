<?php

namespace hypeJunction\Media;

interface MediaCollection {

	/**
	 * Add media to collection
	 *
	 * @param MediaObject $media_object Media
	 *
	 * @return bool
	 */
	public function addMedia(MediaObject $media_object);

	/**
	 * Remove media from collection
	 *
	 * @param MediaObject $media_object Media object
	 *
	 * @return void
	 */
	public function removeMedia(MediaObject $media_object);

	/**
	 * Check if media is in collection
	 *
	 * @param MediaObject $media_object Media object
	 *
	 * @return bool
	 */
	public function hasMedia(MediaObject $media_object);

	/**
	 * Get media from this collection
	 *
	 * @param array $options ege* options
	 *
	 * @return \hypeJunction\Lists\Collection
	 */
	public function getMedia(array $options = []);
}
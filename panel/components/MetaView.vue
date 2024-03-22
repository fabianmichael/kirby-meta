<template>
  <k-inside>
    <k-header>
      Metadata
      <template #buttons>
        <k-button
          text="Validate internal links"
          icon="wand"
          :disabled="isBusy"
          @click="checkInternalLinks"
        />
        <k-languages-dropdown />
      </template>
    </k-header>
    <table class="k-meta">
      <thead>
        <tr>
          <th>
            <span class="k-meta-title">
              <span class="k-meta-caps">Title Override</span>
            </span>
          </th>
          <th>
            <span class="k-meta-title">
              <span class="k-meta-caps">Meta Description</span>
            </span>
          </th>
          <th>
            <span class="k-meta-title">
              <span class="k-meta-caps">Share Title</span>
            </span>
          </th>
          <th style="width: 14rem">
            <span class="k-meta-title">
              <span class="k-meta-caps">Share Description</span>
            </span>
          </th>
          <th class="k-meta-thumbnail-col">
            <k-icon type="image" />
          </th>
          <th style="width: 14rem">
            <span class="k-meta-title">
              <k-icon type="image" />
              <span class="k-meta-caps">Alt</span>
            </span>
          </th>
          <th style="width: 3rem; text-align: center;">
            <span class="sr-only">Robots</span>
            <k-icon type="meta-searcheye" style="margin-inline: auto;" />
          </th>
          <th style="width: 3rem; text-align: center;">
            <span class="sr-only">Link validation</span>
            <k-icon type="url" style="margin-inline: auto;" />
          </th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(page, id) in pages" >
          <tr
            :key="id + '_head'"
            :data-is-indexible="page.is_indexible"
          >
            <th colspan="8" class="k-meta-page-header-col">
              <div class="k-meta-page-header">
                <div class="k-meta-status-wrap">
                  <k-status-icon :status="page.status" />
                </div>
                <k-link :to="page.panelUrl">{{ page.title }}</k-link>
                <a :href="page.url" target="_blank" rel="noopener" class="k-meta-infozone">
                  <k-icon type="url"/>
                  <span>{{ page.shortUrl }}</span>
                </a>
                <span class="k-meta-infozone">
                  <k-icon :type="page.icon || 'page'"/>
                  <span>{{ page.template }}</span>
                </span>
              </div>
            </th>
          </tr>
          <tr
            :key="id + '_content'"
            :data-is-indexible="page.is_indexible"
          >
            <td>
              <div v-if="page.meta_title" class="k-meta-text-xs k-meta-max-3-lines">{{ page.meta_title }}</div>
              <template v-else>—</template>
            </td>
            <td>
              <div v-if="page.meta_description" class="k-meta-text-xs k-meta-max-3-lines">{{ page.meta_description }}</div>
              <template v-else>—</template>
            </td>
            <td>
              <div v-if="page.og_title" class="k-meta-text-xs k-meta-max-3-lines">{{ page.og_title }}</div>
              <template v-else>—</template>
            </td>
            <td>
              <div v-if="page.og_description" class="k-meta-text-xs k-meta-max-3-lines">{{ page.og_description }}</div>
              <div v-else-if="page.meta_description" class="k-meta-text-xs k-meta-max-3-lines" style="opacity: 0.5;">[Meta description]</div>
              <template v-else>—</template>
            </td>
            <td class="k-meta-thumbnail-col">
              <k-image
                v-if="page.og_image_url"
                :src="page.og_image_url"
                :cover="true"
                ratio="1200/630"
                back="pattern"
              />
              <div v-else style="text-align: center;">—</div>
            </td>
            <td>
              <div v-if="page.og_image_alt" class="k-meta-text-xs k-meta-max-3-lines">{{ page.og_image_alt}}</div>
              <template v-else>—</template>
            </td>
            <td style="text-align: center;">
              <k-icon
                :type="page.is_indexible ? 'meta-true' : 'meta-false'"
                style="margin-inline: auto;"
              />
            </td>
            <td style="text-align: center;">
              <k-icon
                :type="(page.internalLinksResult && page.internalLinksResult.message) ? 'meta-false' : 'meta-true'"
                style="margin-inline: auto;"
                v-if="page.internalLinksResult"
              />
              <template v-else>—</template>
            </td>
          </tr>
          <tr
            :key="id + '_internal_links_result'"
            v-if="page.internalLinksResult && page.internalLinksResult.message"
          >
            <td colspan="8" class="k-meta-result">
              <k-box theme="negative">
                <k-text size="tiny">
                  <p>{{ page.internalLinksResult.message }}</p>
                  <ul v-if="page.internalLinksResult.brokenLinks">
                    <li v-for="(value, index) in page.internalLinksResult.brokenLinks" :key="index" v-html="value"/>
                  </ul>
                </k-text>
              </k-box>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </k-inside>
</template>

<script>
export default {
  props: {
    dir: String,
    sort: String,
    pages: Object,
  },
  data() {
    return {
      isBusy: false,
    }
  },
  methods: {
    async checkInternalLinks() {
      this.isBusy = true;

      // Reset
      for (let i = 0, l = this.pages.length; i < l; i++) {
        const page = this.pages[i];
        page.internalLinksResult = null;
        this.$set(this.pages, i, page);
      }

      // Get new results
      for (let i = 0, l = this.pages.length; i < l; i++) {
        const page = this.pages[i];
        const id   = page.id;
        const result = await window.panel.api.get(`meta/check-internal-links`, {
          id,
          language: (this.$multilang ? this.$language.code : null),
        });
        page.internalLinksResult = result;
        this.$set(this.pages, i, page);
      }
      this.isBusy = false;
    },
  },
};
</script>

<style>
.k-meta {
  width: calc(100% - var(--spacing-4));
  margin: 0 var(--spacing-2);
  table-layout: fixed;
  border-spacing: 0;
}

.k-meta td,
.k-meta th {
  text-align: left;
  font-size: var(--text-sm);
  padding: var(--spacing-2);
  vertical-align: top;
}

.k-meta th {
  font-weight: 500;
}

.k-meta thead th {
  border-top-left-radius: var(--rounded);
  border-top-right-radius: var(--rounded);
  position: sticky;
  top: 0; /* Don't forget this, required for the stickiness */
  z-index: 10;
}

.k-meta tbody tr:last-child td {
  border-bottom-left-radius: var(--rounded);
  border-bottom-right-radius: var(--rounded);
}

.k-meta td:first-child,
.k-meta th:first-child {
  padding-left: calc(var(--spacing-2) + 1rem);
}

.k-meta td:nth-child(even),
.k-meta th:nth-child(even) {
  background: var(--color-gray-100);
}

.k-meta td:nth-child(odd),
.k-meta th:nth-child(odd) {
  background: var(--color-background);
}

.k-meta tbody tr:not([data-is-indexible="true"]) {
  color: var(--color-gray-600);
}

.k-meta tbody tr:not([data-is-indexible="true"]) .k-image {
  opacity: .8;
}

.k-meta .k-meta-result {
  color: var(--color-gray-900);
  padding-right: 0;
}

.k-meta .k-meta-result-content {
  padding: var(--spoacing-3);
  background: var(--color-white);
}

.k-meta-title {
  display: flex;
}

.k-meta-title > * + * {
  margin-left: var(--spacing-2);
}

.k-meta-caps {
  text-transform: uppercase;
  font-size: var(--text-xs);
  font-weight: 600;
  line-height: 1rem;
  letter-spacing: .02em;
  width: 100%;
  overflow: hidden;
  text-overflow: ellipsis;
}

.k-meta-thumbnail-col {
  box-sizing: content-box;
  width: 6rem;
}

.k-meta-thumbnail-col .k-image {
  display: block;
  margin: 0 auto;
  width: 6rem;
}

.k-meta .k-meta-page-header-col {
  padding: 0 !important;
}

.k-meta-page-header {
  position: relative;
  align-items: center;
  display: grid;
  gap: var(--spacing-2);
  grid-template-columns: min-content 1fr 3fr auto;
  background: var(--color-white);
  border-radius: var(--rounded);
  box-shadow: var(--shadow);
  padding: var(--spacing-2);
  margin: 0 calc(-1 * var(--spacing-2));
}

.k-meta-infozone {
  font-weight: var(--font-normal);
  color: var(--color-gray-600);
  font-size: var(--text-xs);
  font-family: var(--font-mono);
  display: flex;
  align-items: center;
}

.k-meta-infozone > * + * {
  margin-left: var(--spacing-2);
}

.k-meta-infozone .k-icon {
  --size: .75rem;
}

.k-meta-status-wrap {
  height: 1rem;
  width: 1rem;
  line-height: 1;
  pointer-events: none;
}

.k-meta-text-xs {
  font-size: var(--text-xs);
  line-height: var(--leading-snug);
}

.k-meta-max-3-lines {
  width: 100%;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 3;
  overflow: hidden;
}

</style>

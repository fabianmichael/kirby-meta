<template>
  <k-inside>
    <k-view>
      <k-header>
        Metadata
        <k-button-group slot="left">
          <k-button
            text="Validate links"
            icon="wand"
            @click="checkLinks"
          />
        </k-button-group>
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
                <k-icon type="share" />
                <span class="k-meta-caps">Title</span>
              </span>
            </th>
            <th style="width: 14rem">
              <span class="k-meta-title">
                <k-icon type="share" />
                <span class="k-meta-caps">Description</span>
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
            <th style="width: 3rem">
              <span class="sr-only">All links are valid</span>
              <k-icon type="url" />
            </th>
          </tr>
        </thead>
        <tbody>
          <template v-for="(page, id) in pages" >
            <tr :key="id + '_head'">
              <th colspan="7" class="k-meta-page-header-col">
                <div class="k-meta-page-header">
                  <k-icon :type="page.icon || 'page'" />
                  <k-link :to="page.panelUrl + '?tab=meta'">{{ page.title }}</k-link>
                  <code>{{ page.id }}</code>
                  <span class="k-meta-template"><k-icon type="template"/><span>{{ page.template }}</span></span>
                </div>
              </th>
            </tr>
            <tr :key="id + '_content'">
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
                <template v-else>—</template>
              </td>
              <td class="k-meta-thumbnail-col">
                <template v-if="page.og_image">
                  <k-link :to="page.og_image_panelUrl">
                    <k-image
                      v-bind="page.og_image"
                      :cover="true"
                      ratio="1200/630"
                      back="pattern"
                    />
                  </k-link>
                </template>
                <div v-else class="k-meta-center">—</div>
              </td>
              <td>
                <div v-if="page.og_image_alt" class="k-meta-text-xs k-meta-max-3-lines">{{ page.og_image_alt}}</div>
                <template v-else>—</template>
              </td>
              <td><div class="k-meta-center">?</div></td>

            </tr>
          </template>
        </tbody>
      </table>
    </k-view>
  </k-inside>
</template>

<script>
export default {
  props: {
    dir: String,
    sort: String,
    pages: Object,
  },
  computed: {
    // sortArrow() {
    //   return this.dir === "asc" ? "↓" : "↑";
    // },
  },
  methods: {
    checkLinks() {
    },

    // sortBy(sort) {
    //   // sort ascending by default
    //   let dir = "asc";

    //   // toggle direction when resorting the same column
    //   if (sort === this.sort) {
    //     dir = this.dir === "asc" ? "desc" : "asc";
    //   }

    //   // refresh the view with the updated query parameters
    //   this.$reload({
    //     query: {
    //       sort: sort,
    //       dir: dir,
    //     },
    //   });
    // },
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
  /* white-space: nowrap; */
  /* text-overflow: ellipsis; */
  /* overflow: hidden; */
  /* background: var(--color-white); */
}

.k-meta th {
  font-weight: var(--font-bold);
}

.k-meta td:first-child,
.k-meta th:first-child {
  padding-left: calc(var(--spacing-2) + 1rem);
}

.k-meta td:nth-child(even),
.k-meta th:nth-child(even) {
  background: var(--color-gray-100);
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
  line-height: 1rem;
  letter-spacing: .01em;
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

.k-meta-center {
  text-align: center;
}

.k-meta .k-meta-page-header-col {
  padding: 0 !important;
}

.k-meta-page-header {
  position: relative;
  align-items: center;
  display: grid;
  gap: var(--spacing-2);
  grid-template-columns: min-content auto 1fr auto;
  background: var(--color-white);
  border-radius: var(--rounded-sm);
  box-shadow: var(--shadow);
  padding: var(--spacing-2);
  margin: 0 calc(-1 * var(--spacing-2));
}

.k-meta-template {
  font-weight: var(--font-normal);
  color: var(--color-gray-500);
  font-size: var(--text-xs);
  font-family: var(--font-mono);
  display: flex;
}

.k-meta-template > * + * {
  margin-left: var(--spacing-1);
}

.k-meta-template .k-icon {
  --size: .75rem;
}

/* .k-meta-page-header > * + * {
  margin-left: var(--spacing-2);
} */

.k-meta-page-header code {
  justify-self: start;
  background: var(--color-gray-200);
  border-radius: var(--rounded-sm);
  padding: var(--spacing-2px) var(--spacing-1);
  font-size: var(--text-xs);
  font-weight: var(--font-normal);
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

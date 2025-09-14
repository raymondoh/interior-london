export function initLoadMore() {
  const btn = document.getElementById("load-more-projects");
  if (!btn) return;

  const target = document.getElementById("project-results");
  if (!target) return;

  let state = {
    paged: 2, // next page to fetch
    busy: false,
    haveMore: true
  };

  btn.addEventListener("click", async e => {
    e.preventDefault();
    if (state.busy || !state.haveMore) return;

    state.busy = true;
    btn.classList.add("opacity-60");
    btn.textContent = "Loading...";

    try {
      const response = await fetch(INTERIOR_LOAD_MORE.ajax_url, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
          action: "interior_load_more",
          nonce: INTERIOR_LOAD_MORE.nonce,
          paged: state.paged,
          ppp: INTERIOR_LOAD_MORE.ppp,
          year: INTERIOR_LOAD_MORE.year,
          term_id: INTERIOR_LOAD_MORE.term_id,
          view: INTERIOR_LOAD_MORE.view,
          "exclude[]": INTERIOR_LOAD_MORE.exclude || []
        })
      });

      const data = await response.json();

      if (data.success) {
        target.insertAdjacentHTML("beforeend", data.data.html);
        state.paged = data.data.next_paged;
        state.haveMore = !!data.data.have_more;

        if (!state.haveMore) {
          btn.remove();
        } else {
          btn.classList.remove("opacity-60");
          btn.textContent = "Load More Projects";
        }
      } else {
        btn.textContent = "No more projects";
      }
    } catch (err) {
      console.error("Load More Error:", err);
      btn.textContent = "Error — try again";
    } finally {
      state.busy = false;
    }
  });
}

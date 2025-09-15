// export function initLoadMore() {
//   const btn = document.getElementById("load-more-projects");
//   if (!btn) return;

//   const target = document.getElementById("project-results");
//   if (!target) return;

//   let state = {
//     paged: 2, // next page to fetch
//     busy: false,
//     haveMore: true
//   };

//   btn.addEventListener("click", async e => {
//     e.preventDefault();
//     if (state.busy || !state.haveMore) return;

//     state.busy = true;
//     btn.classList.add("opacity-60");
//     btn.textContent = "Loading...";

//     try {
//       const response = await fetch(INTERIOR_LOAD_MORE.ajax_url, {
//         method: "POST",
//         headers: { "Content-Type": "application/x-www-form-urlencoded" },
//         body: new URLSearchParams({
//           action: "interior_load_more",
//           nonce: INTERIOR_LOAD_MORE.nonce,
//           paged: state.paged,
//           ppp: INTERIOR_LOAD_MORE.ppp,
//           term_id: INTERIOR_LOAD_MORE.term_id,
//           view: INTERIOR_LOAD_MORE.view,
//           "exclude[]": INTERIOR_LOAD_MORE.exclude || []
//         })
//       });

//       const data = await response.json();

//       if (data.success) {
//         target.insertAdjacentHTML("beforeend", data.data.html);
//         state.paged = data.data.next_paged;
//         state.haveMore = !!data.data.have_more;

//         if (!state.haveMore) {
//           btn.remove();
//         } else {
//           btn.classList.remove("opacity-60");
//           btn.textContent = "Load More Projects";
//         }
//       } else {
//         btn.textContent = "No more projects";
//       }

//     } catch (err) {
//       console.error("Load More Error:", err);
//       btn.textContent = "Error — try again";
//     } finally {
//       state.busy = false;
//     }
//   });
// }
export function initLoadMore() {
  const btn = document.getElementById("load-more-projects");
  if (!btn) return;

  const target = document.getElementById("project-results");
  if (!target) return;

  const wrapper = btn.parentElement; // <div class="mt-12 text-center">...</div>

  let state = {
    paged: 2, // next page to fetch
    busy: false,
    haveMore: true
  };

  function showNoMore() {
    // Create a disabled, secondary-style “No more projects” button in place of the old one
    const msg = document.createElement("button");
    msg.type = "button";
    msg.textContent = "No more projects";
    msg.disabled = true;
    msg.className = "btn-secondary btn-compact opacity-60 cursor-not-allowed";

    // Replace the load more button in-place
    if (btn.isConnected) {
      btn.replaceWith(msg);
    } else if (wrapper) {
      wrapper.appendChild(msg);
    }
    state.haveMore = false;
  }

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
          term_id: INTERIOR_LOAD_MORE.term_id,
          view: INTERIOR_LOAD_MORE.view,
          "exclude[]": INTERIOR_LOAD_MORE.exclude || []
        })
      });

      const data = await response.json();

      if (!data || !data.success) {
        showNoMore();
        return;
      }

      const payload = data.data || {};
      const html = payload.html || "";
      const next = Number(payload.next_paged || 0);
      const haveMoreFlag = !!payload.have_more;

      if (html.trim().length) {
        target.insertAdjacentHTML("beforeend", html);
      }

      // Derive “have more” robustly:
      // - prefer explicit have_more
      // - else, if next is falsy/0/NaN, assume no more
      // - else, if HTML came back empty, assume no more
      let derivedHaveMore = haveMoreFlag;
      if (!("have_more" in payload)) {
        derivedHaveMore = !!(next && !Number.isNaN(next) && html.trim().length > 0);
      }

      if (!derivedHaveMore) {
        showNoMore();
      } else {
        state.paged = next || state.paged + 1;
        state.haveMore = true;
        btn.classList.remove("opacity-60");
        btn.textContent = "Load More Projects";
      }
    } catch (err) {
      console.error("Load More Error:", err);
      // Keep the button so the user can retry
      btn.classList.remove("opacity-60");
      btn.textContent = "Error — try again";
    } finally {
      state.busy = false;
    }
  });
}

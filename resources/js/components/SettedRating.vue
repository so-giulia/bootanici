<template>
  <div class="star-rating">
        <label class="star-rating__star" v-for="rating in ratings" :key="rating.id"
        :class="{'is-selected': ((value >= rating) && value != null), 'is-disabled': disabled}"
        v-on:click="set(rating)" v-on:mouseover="star_over(rating)" v-on:mouseout="star_out">
            <input class="star-rating star-rating__checkbox" type="radio" :value="rating" :name="name" 
            v-model="value" :disabled="disabled">
            ★
        </label>
  </div>
</template>

<script>
export default {
    name: 'SettedRating',
    data(){
        return {
            temp_value: null,
            ratings: [1, 2, 3, 4, 5]
        }
    },
    props: {
        'name': String,
        'value': null,
        'id': String,
        'disabled': Boolean,
        'required': Boolean
    },
    methods: {
        //stars on mouseover
        star_over(index){
            var self = this;

            if (!this.disabled) {
                this.temp_value = this.value;
                return this.value = index;
            }
        },

        //stars on mouseout
        star_out(){
            var self = this;

            if (!this.disabled) {
                return this.value = this.temp_value;
            }
        },

        //set the rating
        set(value){
            var self = this;

            if (!this.disabled) {
                this.temp_value = value;
                return this.value = value;
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    %visually-hidden {
        position: absolute;
        overflow: hidden;
        clip: rect(0 0 0 0);
        height: 1px; width: 1px;
        padding: 0; border: 0;
    }

    .star-rating {
        margin-left: -2px;

        &__star {
            display: inline-block;
            padding: 1px;
            vertical-align: middle;
            font-size: 1rem;
            color: #d9d9d9;
            transition: color .2s ease-out;
            margin-bottom:0;

            &:hover {
                cursor: pointer;
            }
            
            &.is-selected {
                color: #FFD700;
            }
            
            &.is-disabled:hover {
                cursor: default;
            }
        }

    &__checkbox {
        @extend %visually-hidden;
    }
    }
</style>